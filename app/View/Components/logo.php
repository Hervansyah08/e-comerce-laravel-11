<?php

namespace App\View\Components;

use Closure;
use App\Models\Store;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class logo extends Component
{
    /**
     * Create a new component instance.
     */
    public $store;
    public function __construct()
    {
        $this->store = Store::first();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.logo');
    }
}
