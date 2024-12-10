<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{

    public function index(Request $request)
    {
        try {
            // Ambil data pesanan dengan filter pencarian dan status
            $orders = Order::with(['user', 'orderItems.product', 'ongkir']) // Relasi pengguna dan produk
                ->whereIn('status', ['dibayar', 'sedang diproses', 'dikirim']) // Filter status
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
                    if (in_array($status, ['dibayar', 'sedang diproses', 'dikirim'])) {
                        $query->where('status', $status);
                    }
                })
                ->latest() // Urutkan berdasarkan terbaru
                ->paginate(10) // Paginate hasil
                ->withQueryString(); // Sertakan query string pada pagination links

            return view('admin.order', compact('orders')); // Kirim data ke view
        } catch (\Exception $e) {
            // Catat error ke log dan tampilkan pesan kesalahan
            Log::error("Gagal mengambil data order: " . $e->getMessage());
            return back()->withErrors('Gagal memuat data pesanan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Order $order, Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'status' => 'required|string',
                'resi_code' => 'required_if:status,dikirim|string|nullable',
                // ini jika status dikirim wajib diisi resi kode nya
            ], [
                'status.required' => 'Status wajib diisi',
                'resi_code.required_if' => 'Nomor resi wajib diisi jika status pengiriman dikirim',
            ]);

            $updateData = ['status' => $request->status];
            if ($request->status === 'dikirim') {
                if (empty($request->resi_code)) {
                    throw new Exception('Nomor resi diperlukan untuk status pengiriman');
                }
                $updateData['resi_code'] = $request->resi_code;
            } else {
                // Jika status bukan "dikirim", hapus resi_code
                $updateData['resi_code'] = null;
            }

            $order->update($updateData);

            DB::commit();
            return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal mengubah status pesanan: " . $e->getMessage());
            return back()->with('error', 'Gagal mengubah status pesanan: ' . $e->getMessage());
        }
    }
}
