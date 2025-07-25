<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderHistoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil data pesanan dengan filter pencarian dan status
            $orders = Order::query()
                ->with(['user', 'orderItems.product', 'ongkir']) // Relasi pengguna dan produk
                ->whereIn('status', [
                    'terkirim',
                    'dibatalkan',
                ]) // Filter status
                ->when($request->search, function ($query, $search) {
                    $query->where('order_code', 'like', "%{$search}%")
                        ->orWhere('alamat_pengiriman', 'like', "%{$search}%")
                        ->orWhere('resi_code', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                })
                ->when($request->status, function ($query, $status) {
                    if (in_array($status, ['terkirim', 'dibatalkan'])) {
                        $query->where('status', $status);
                    }
                })
                ->latest() // Urutkan berdasarkan terbaru
                ->paginate(10) // Paginate hasil
                ->withQueryString(); // Sertakan query string pada pagination links

            return view('admin.order-history', compact('orders')); // Kirim data ke view
        } catch (\Exception $e) {
            // Catat error ke log dan tampilkan pesan kesalahan
            Log::error("Gagal mengambil data order: " . $e->getMessage());
            return back()->withErrors('Gagal memuat data pesanan: ' . $e->getMessage());
        }
    }

    public function orderReceived(Order $order)
    {
        try {
            DB::beginTransaction();

            $order->status = 'terkirim';
            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Diterima');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal mengubah status pesanan: " . $e->getMessage());
            return back()->with('error', 'Gagal mengubah status pesanan: ' . $e->getMessage());
        }
    }
    public function cancelOrder(Order $order)
    {
        try {
            DB::beginTransaction();

            $order->status = 'dibatalkan';
            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan Dibatalkan');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal membatalkan pesanan: " . $e->getMessage());
            return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    public function edit(Order $order) //menggunakan route model binding
    {
        try {
            return view('landing.ulasan', compact('order'));
        } catch (\Exception $e) {
            Log::channel('program')->error('Error loading Ulasan form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat form ulasan.');
        }
    }

    public function updateUlasan(Request $request, Order $order)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'required|string|max:1000',
        ]);

        $order->update([
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return redirect()->route('user.orders.history')->with('success', 'Ulasan berhasil dikirim.');
    }

    public function detailUlasan(Order $order) //menggunakan route model binding
    {
        try {
            return view('landing.detail-ulasan', compact('order'));
        } catch (\Exception $e) {
            Log::channel('program')->error('Error loading Detail Ulasan: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat detail ulasan.');
        }
    }
}
