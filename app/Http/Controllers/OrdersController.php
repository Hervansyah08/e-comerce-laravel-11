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
            $orders = Order::with(['user', 'orderItems.product']) // Relasi pengguna dan produk
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
}
