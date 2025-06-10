<?php

use App\Models\Order;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon; // Tambahkan import untuk Carbon

Artisan::command('check-expired', function () {
    // Cari pesanan dengan status 'pending' dan memiliki snap_token
    $orders = Order::where('status', 'pending')
        ->whereNotNull('snap_token')
        ->get();

    foreach ($orders as $order) {
        // Periksa apakah pesanan sudah lebih dari 24 jam
        $createdAt = Carbon::parse($order->created_at); // memparsing ke dalam carbon
        $now = Carbon::now();
        $diffInHours = $createdAt->diffInHours($now); // menghitung perbedaan dalam jam

        if ($diffInHours > 24) {
            // Batalkan pesanan jika sudah lebih dari 24 jam
            $order->status = 'dibatalkan';
            $order->save();
            $this->info("Order {$order->order_code} dibatalkan karena sudah lebih dari 24 jam.");
        }
    }

    $this->info('update status berhasil');
    return 0;
})->everyMinute(5);
