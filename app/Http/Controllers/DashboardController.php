<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        try {
            $totalSalesThisMonth = $this->dashboardService->totalSalesThisMonth();
            $totalOrders = $this->dashboardService->totalOrders();
            $orderStatus = $this->dashboardService->orderStatus();
            $totalProducts = $this->dashboardService->totalProducts();
            $totalCustomer = $this->dashboardService->totalCustomer();
            $inStock = $this->dashboardService->inStock();
            $lowStock = $this->dashboardService->lowStock();
            return view('admin.dashboard', compact(
                'totalSalesThisMonth',
                'totalOrders',
                'orderStatus',
                'totalProducts',
                'totalCustomer',
                'inStock',
                'lowStock',
            ));
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }
}
