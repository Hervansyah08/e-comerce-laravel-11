<?php

namespace App\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class DashboardService
{
    public function totalSalesThisMonth()
    {
        try {
            return Order::whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereIn('status', [
                    'dibayar',
                    'sedang diproses',
                    'dikirim',
                    'terkirim',
                ])
                ->sum('total_price');
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data total penjualan bulan ini:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data total penjualan bulan ini");
        }
    }

    public function totalOrders()
    {
        try {
            return Order::count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data total pesanan:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data total pesanan");
        }
    }

    public function orderStatus()
    {
        try {
            $orderStatus = [
                'pending' => Order::where('status', 'pending')->count(),
                'paid' => Order::where('status', 'dibayar')->count(),
                'processing' => Order::where('status', 'sedang diproses')->count(),
                'send'  => Order::where('status', 'dikirim')->count(),
                'completed' => Order::where('status', 'terkirim')->count(),
                'canceled' => Order::where('status', 'dibatalkan')->count(),
            ];
            return $orderStatus;
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data status penjualan:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data status penjualan");
        }
    }

    public function totalProducts()
    {
        try {
            return Product::count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data total produk:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data total produk");
        }
    }
    public function totalCustomer()
    {
        try {
            return User::role('user')
                ->count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data total customer:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data total customer");
        }
    }
    public function inStock()
    {
        try {
            return Product::where('is_active', true)
                ->where('stock', '>', 0)
                ->pluck('stock')
                ->count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data produk yang tersedia:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data produk yang tersedia");
        }
    }

    public function lowStock()
    {
        try {
            return Product::where('is_active', true)
                ->where('stock', '<=', 2)
                ->pluck('stock')
                ->count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data produk dengan stok rendah: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data produk dengan stok rendah");
        }
    }

    public function getMonthlyIncomeData()
    {
        $tahun = date('Y');
        $bulan = date('m');

        $dataBulan = [];
        $dataTotalPendapatan = [];

        for ($i = 1; $i <= $bulan; $i++) {
            $totalPendapatan = Order::whereMonth('created_at', $i)
                ->whereYear('created_at', $tahun)
                ->whereIn('status', [
                    'dibayar',
                    'sedang diproses',
                    'dikirim',
                    'terkirim',
                ])
                ->sum('total_price');

            $dataBulan[] = Carbon::create()->month($i)->locale('id')->translatedFormat('F');
            $dataTotalPendapatan[] = $totalPendapatan;
        }

        return [
            'labels' => $dataBulan,
            'data' => $dataTotalPendapatan,
        ];
    }

    public function Activethismonth()
    {
        try {
            return User::whereMonth('updated_at', Carbon::now()->month)
                ->whereYear('updated_at', Carbon::now()->year)
                ->role('user')
                ->count();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data total customer yang aktif bulan ini:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data total customer  yang aktif bulan ini");
        }
    }
}
