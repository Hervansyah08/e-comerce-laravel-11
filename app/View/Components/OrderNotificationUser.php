<?php

namespace App\View\Components;

use Closure;
use App\Models\Order;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class OrderNotificationUser extends Component
{
    /**
     * Create a new component instance.
     */
    public $orders;
    public function __construct()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->orders = Order::where('user_id', $user->id)
                ->whereIn('status', ['Sedang diproses', 'dikirim'])
                ->get();
        } else {
            $this->orders = collect(); // Biar nggak error di view kalau user belum login
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.order-notification-user');
    }
}
