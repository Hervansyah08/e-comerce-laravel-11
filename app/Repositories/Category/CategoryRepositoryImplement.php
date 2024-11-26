<?php

namespace App\Repositories\Category;

use Exception;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
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
            return $this->model::query() // query ini sebuah kuas yang akan kamu gunakan untuk "melukis" sebuah permintaan (query) ke database.
                ->withCount('products') // menghitung jumlah produk
                // when ini untuk kondisi yang lebih kompleks
                // $request->filled('search') Mengecek apakah parameter search di request memiliki nilai
                ->when($request->filled('search'), function ($query) use ($request) {
                    $search = $request->search; // untuk mengambil nilai dari input pengguna (dikirim melalui HTTP request) dengan nama parameter search
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(5)
                ->withQueryString(); // Ini penting untuk mempertahankan parameter search saat paginasi
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data Kategori:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil semua data Kategori");
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
            Log::warning("Gagal menambahkan Kategori :" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat menambahkan Kategori ");
        }
    }
    public function update($id, $data)
    {
        DB::beginTransaction();
        try {
            // Temukan model berdasarkan ID
            $category = $this->model->findOrFail($id)->update($data);
            DB::commit();
            return $category;  // Kembalikan model yang sudah diperbarui
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal mengubah Kategori ID $id: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengubah Kategori ID $id");
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $categoryid = $this->model->findOrFail($id);
            // Mengecek apakah kategori memiliki produk yang terkait
            if ($categoryid->products()->exists()) {
                // Lemparkan exception dengan pesan spesifik
                throw new Exception('Tidak dapat menghapus kategori karena ada produk terkait.');
            }
            $categoryid->delete();
            DB::commit();
            return $categoryid;
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal Hapus Kategori ID $id: " . $e->getMessage());
            throw $e;  // Lemparkan kembali exception yang sama
        }
    }
}
