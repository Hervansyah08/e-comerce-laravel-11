<?php

namespace App\Repositories\Category;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelEasyRepository\Implementations\Eloquent;

class CategoryRepositoryImplement extends Eloquent implements CategoryRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getAll(Request $request)
    {

        try {
            $categories =  $this->model::query() // query ini sebuah kuas yang akan kamu gunakan untuk "melukis" sebuah permintaan (query) ke database.
                ->withCount('products') // menghitung jumlah produk
                // when ini untuk kondisi yang lebih kompleks
                // $request->filled('search') Mengecek apakah parameter search di request memiliki nilai
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search; // untuk mengambil nilai dari input pengguna (dikirim melalui HTTP request) dengan nama parameter search
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(5)
                ->withQueryString(); // Ini penting untuk mempertahankan parameter search saat paginasi
            return  $categories;
        } catch (Exception $e) {
            throw new Exception("Gagal mengambil data Kategori: " . $e->getMessage());
        }
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->create($data);
            DB::commit();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Gagal menambahkan Kategori: " . $e->getMessage());
        }
    }
    public function update($category, $data) {}
    public function delete($category) {}
}
