<?php

namespace App\Repositories\Product;

use App\Models\Category;
use Exception;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
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

    public function getProducts()
    {
        try {
            return $this->model::query()
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
    public function create($data) {}
    public function update($id, $data) {}
    public function delete($id) {}
    public function search($query) {}
}
