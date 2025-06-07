<?php

namespace App\Services;

use Exception;
use App\Models\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StoreService
{
    public function index()
    {
        try {
            return Store::select(
                'id',
                'name',
                'address',
                'phone',
                'image',
            )->get();
        } catch (Exception $e) {
            Log::warning("Gagal mengambil data Store:" . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengambil semua data store");
        }
    }
    public function create($data)
    {
        DB::beginTransaction();
        try {
            // Cek dan simpan file gambar
            if (isset($data['image']) && $data['image']->isValid()) {
                $imagePath = $data['image']->store('store_images', 'public');
            } else {
                $imagePath = null;
            }

            // Simpan data store ke database
            $store = Store::create([
                'name' => $data['name'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'image' => $imagePath,
            ]);

            DB::commit();
            return $store;
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal menambahkan data store: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat menambahkan data store");
        }
    }

    // public function update($id, $data)
    // {
    //     DB::beginTransaction();
    //     try {
    //         // Temukan model berdasarkan ID
    //         $store = Store::findOrFail($id)->update($data);
    //         DB::commit();
    //         return $store;  // Kembalikan model yang sudah diperbarui
    //     } catch (Exception $e) {
    //         DB::rollBack();
    //         Log::warning("Gagal mengubah data store Kategori ID $id: " . $e->getMessage());
    //         throw new Exception("Terjadi kesalahan saat mengubah data store Kategori ID $id");
    //     }
    // }

    public function update($data, Store $store)
    {
        DB::beginTransaction();
        try {
            // Jika ada gambar baru, simpan dan hapus yang lama
            if (isset($data['image']) && $data['image']->isValid()) {
                // Hapus gambar lama jika ada
                if ($store->image && Storage::disk('public')->exists($store->image)) {
                    Storage::disk('public')->delete($store->image);
                }

                // Simpan gambar baru
                $imagePath = $data['image']->store('store_images', 'public');
            } else {
                $imagePath = $store->image; // Gunakan gambar lama jika tidak diubah
            }

            // Update data store
            $store->update([
                'name' => $data['name'],
                'address' => $data['address'],
                'phone' => $data['phone'],
                'image' => $imagePath,
            ]);

            DB::commit();
            return $store;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal mengupdate data store: " . $e->getMessage());
            throw new Exception("Terjadi kesalahan saat mengupdate data store");
        }
    }

    public function delete(Store $store)
    {
        DB::beginTransaction();
        try {
            if ($store->image && Storage::disk('public')->exists($store->image)) {
                Storage::disk('public')->delete($store->image);
            }
            $store->delete();
            DB::commit();
            return $store;
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal Hapus data store ID $store->id: " . $e->getMessage());
            throw $e;
        }
    }
}
