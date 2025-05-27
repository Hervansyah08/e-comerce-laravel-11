<?php

namespace App\View\Components;

use Closure;
use App\Models\Product;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class LatestProducts extends Component
{
    /**
     * Create a new component instance.
     */
    public $products;

    public function __construct()
    {
        $this->products = Product::latest()->take(5)
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.latest-products');
    }
}
