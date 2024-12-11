<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
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
}
