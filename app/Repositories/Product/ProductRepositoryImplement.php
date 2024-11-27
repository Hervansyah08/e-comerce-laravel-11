<?php

namespace App\Repositories\Product;

use Exception;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getProducts(Request $request)
    {
        try {
            return $this->model::query()
                ->with('category')
                // when ini untuk kondisi yang lebih kompleks
                // $request->filled('search') Mengecek apakah parameter search di request memiliki nilai
                ->when($request->filled('search'), function ($q) use ($request) {
                    $search = $request->search; // untuk mengambil nilai dari input pengguna (dikirim melalui HTTP request) dengan nama parameter search
                    $q->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            // ->orWhere('description', 'like', "%{$search}%")
                            ->orWhereHas('category', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%");
                            });
                    });
                })
                ->when($request->filled('category'), function ($q) use ($request) {
                    $q->where('category_id', $request->category);
                })
                ->latest()
                ->paginate(5)
                ->withQueryString();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data produk: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data produk.");
        }
    }
    public function getCategories()
    {
        try {
            return Cache::remember('all_categories', 60 * 60, function () {
                return Category::all();
            });
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data kategori: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil data kategori.");
        }
    }
}
