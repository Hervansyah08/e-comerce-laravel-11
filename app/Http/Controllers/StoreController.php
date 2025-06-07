<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Services\StoreService;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    protected $StoreService;

    public function __construct(StoreService $StoreService)
    {
        $this->StoreService = $StoreService;
    }

    public function index()
    {
        try {
            $stores = $this->StoreService->index();
            return view('admin.store', compact('stores'));
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Failed to load store: ' . $e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        try {
            $this->StoreService->create($validated);
            return redirect()->route('admin.store.index')->with('success', 'Data Store berhasil dibuat');
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Gagal Menambahkan Data Store: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        try {
            $this->StoreService->update($validated, $store);
            return redirect()->route('admin.store.index')->with('success', 'Data Store berhasil diupdate');
        } catch (Exception $e) {
            Log::error("Kesalahan saat update Store: " . $e->getMessage());
            return back()->with('error', 'Gagal Mengupdate Data Store: ' . $e->getMessage())->withInput();
        }
    }
    public function destroy(Store $store)
    {
        try {
            $this->StoreService->delete($store);
            return redirect()->route('admin.store.index')->with('success', 'Data Store berhasil dihapus');
        } catch (Exception $e) {
            Log::error("Kesalahan saat menghapus Store: " . $e->getMessage());
            return back()->with('error', 'Gagal menghapus Store: ' . $e->getMessage());
        }
    }
}
