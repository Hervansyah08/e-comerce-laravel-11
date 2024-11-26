<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Product\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function index(Request $request)
    {
        try {
            if ($request->page != null) {
                Cache::forget('allproduct'); // Hapus cache jika ada parameter pencarian atau paginasi
            }
            $products = $this->productRepository->getProducts();
            $categories = $this->productRepository->getCategories();

            return view('admin.product', compact('products', 'categories'));
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }
}
