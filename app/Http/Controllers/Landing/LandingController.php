<?php
// ini buat menampilakn semua produk di user atau navbar produk
namespace App\Http\Controllers\Landing;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepository;

class LandingController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function product(Request $request)
    {
        try {
            // Mengambil kategori produk
            $categories = $this->productRepository->getCategories();

            // Membuat query produk dengan relasi kategori
            $query = Product::with('category')
                ->where('is_active', true)
                ->where('stock', '>', 0);

            // Filter berdasarkan nama produk
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            // Filter berdasarkan kategori
            if ($request->category) {
                $query->where('category_id', $request->category);
            }

            // Mengurutkan produk berdasarkan parameter 'sort'
            if ($request->sort) {
                switch ($request->sort) {
                    case 'price_low':
                        $query->orderBy('price', 'asc');
                        break;

                    case 'price_high':
                        $query->orderBy('price', 'desc');
                        break;

                    case 'terbaru':
                        $query->latest();
                        break;

                    default:
                        $query;
                }
            } else {
                $query;
            }

            // Melakukan paginasi produk
            $products = $query->paginate(9);

            // Menambahkan parameter query yang ada ke URL saat paginasi
            $products = $products->appends($request->all());

            // Mengirim data ke view
            return view('landing.product', compact('products', 'categories'));
        } catch (\Exception $e) {
            // Menangani error dan log
            Log::error("Gagal mengambil data produk untuk user: " . $e->getMessage());
            return back()->withErrors('Gagal memuat data produk untuk user: ' . $e->getMessage());
        }
    }
}
