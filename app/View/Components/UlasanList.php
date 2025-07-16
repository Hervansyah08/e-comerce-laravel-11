<?php

namespace App\View\Components;

use Closure;
use App\Models\Order;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class UlasanList extends Component
{
    /**
     * Create a new component instance.
     */
    public $orders;
    public function __construct()
    {
        $this->orders = Order::whereNotNull('ulasan')
            ->whereNotNull('rating')
            ->latest() // Urutkan berdasarkan terbaru
            ->paginate(10) // Paginate hasil
            ->withQueryString(); // Sertakan query string pada pagination links
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ulasan-list');
    }
}
