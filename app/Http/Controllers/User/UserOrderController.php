<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    // untuk menampilkan riwayat pesananan berdasarkan user yang login
    public function index(Request $request)
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', auth()->id())
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where('order_code', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(5);

        return view('landing.order-history', compact('orders'));;
    }
}
