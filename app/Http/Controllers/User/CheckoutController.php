<?php

namespace App\Http\Controllers\User;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;
use App\Models\Ongkir;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\PembayaranBerhasilMail;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function __construct()
    {
        // Set Midtrans config
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_ENVIRONMENT') === 'production';
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function process(Request $request)
    {
        DB::beginTransaction();

        try {
            // Gabungkan detail pengiriman
            $alamatPengiriman = sprintf(
                "Nama: %s, Telepon: %s, Detail: %s",
                $request->nama,
                $request->telepon,
                $request->alamat ?? '-'
            );
            $ongkirRecord = Ongkir::create([
                'ekspedisi' => session('ekspedisi'),
                'layanan' => session('ongkir')['description'],
                'biaya' => session('ongkir')['cost'][0]['value'],
                'estimasi' => session('ongkir')['cost'][0]['etd'],
            ]);
            // Create new order
            $order = Order::create([
                'order_code' => 'ORDER-' . uniqid(),
                'user_id' => auth()->id(),
                'alamat_pengiriman' => $alamatPengiriman,
                'total_price' => 0.00,
                'status' => 'pending',
                'ongkir_id' => $ongkirRecord->id,
            ]);

            $cart = session('cart', []);
            $totalPrice = 0;
            $items = [];

            // Loop through cart to create order items and calculate total price
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                $totalPrice += $item['price'] * $item['quantity'];

                $items[] = [
                    'id' => $item['id'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'name' => $item['name'],
                ];
            }

            // Add shipping cost
            $ongkir = session('ongkir');
            $hargaOngkir = $ongkir['cost'][0]['value'];
            $totalPrice += $hargaOngkir;

            // Update order total price
            $order->update(['total_price' => $totalPrice]);

            // $params adalah sebuah array yang digunakan untuk mengonfigurasi pembayaran menggunakan Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => (int) $totalPrice,
                ],
                'item_details' => array_merge($items, [
                    [
                        'id' => 'ongkir',
                        'price' => $hargaOngkir,
                        'quantity' => 1,
                        'name' => 'Biaya Pengiriman'
                    ]
                ]),
                'customer_details' => [
                    'first_name' => $request->nama,
                    'email' => auth()->user()->email,
                    'phone' => $request->telepon,
                    'billing_address' => [
                        'address' => $alamatPengiriman
                    ],
                    'shipping_address' => [
                        'address' => $alamatPengiriman
                    ]
                ]
            ];

            // Menghasilkan Snap Token  dengan mengirimkan data transaksi ke Midtrans.
            $snapToken = Snap::getSnapToken($params);

            // Check if Snap token is generated
            if (empty($snapToken)) {
                throw new Exception('Gagal membuat Token Snap');
            }

            // Update order with Snap token
            $order->update([
                'snap_token' => $snapToken,
            ]);

            // Commit transaction
            DB::commit();

            session()->forget('cart');
            session()->forget('ongkir');
            session()->forget('ekspedisi');

            // Return Snap token for frontend payment process
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollBack();
            Log::error('Transaction failed, rollback:', ['error' => $e->getMessage()]);

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function updateStatus(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'order_id' => 'required',
                'transaction_id' => 'required',
                'payment_type' => 'required',
                'status' => 'required|in:dibayar,pending,dibatalkan,dikirim'
            ]);

            // Gunakan 'order_code' untuk mencari order, bukan 'id'
            $order = Order::where('order_code', $request->order_id)->firstOrFail();

            // Pastikan user hanya bisa update ordernya sendiri
            if ($order->user_id !== auth()->id()) {
                throw new Exception('Akses tidak sah');
            }

            foreach ($order->orderItems as $item) {
                $product = $item->product;

                if (!$product) {
                    throw new Exception("Produk tidak ditemukan untuk item {$item->id}");
                }

                if ($product->stock < $item->quantity) {
                    throw new Exception("Stok untuk produk '{$product->name}' tidak mencukupi.");
                }

                // Kurangi stok produk
                $product->decrement('stock', $item->quantity);
            }

            // Update status pesanan
            $order->update([
                'status' => $request->status,
                'midtrans_transaction_id' => $request->transaction_id,
                'midtrans_payment_type' => $request->payment_type
            ]);

            if ($request->status === 'dibayar') {
                Mail::to($order->user->email)->send(new PembayaranBerhasilMail($order));
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Status pesanan berhasil diperbarui'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating order status: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
