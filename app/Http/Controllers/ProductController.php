<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            $products = $this->productRepository->getProducts($request);
            $categories = $this->productRepository->getCategories();

            return view('admin.product', compact('products', 'categories'));
        } catch (Exception $e) {
            Log::error("Kesalahan di controller" . $e->getMessage());
            return back()->with('error', 'Failed to load categories: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'berat' => 'required|integer|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $image = null;
            if ($request->hasFile('image')) { // jika ada file yang di-upload dengan nama input image pada request
                $file = $request->file('image'); // simpanm di variable file
                // getRealPath() mendapatkan path file gambar yang di-upload di server sementara (sebelum disalin ke storage).
                // file_get_contents() membaca isi file tersebut dan menyimpannya dalam variabel $content.
                // Pada titik ini, $content berisi data biner dari file gambar yang di-upload.
                $content = file_get_contents($file->getRealPath());
                $extension = $file->getClientOriginalExtension(); // mendapatkan ekstensi
                // base64_encode() mengkonversi data biner yang ada dalam $content menjadi string Base64
                $base64 = base64_encode($content);
                // Menggabungkan informasi tipe MIME (misalnya image/jpeg, image/png) dengan string Base64.
                $image = "data:image/{$extension};base64,{$base64}";
                // jadi gambar di simpan dalam bentuk base64 di database
            }

            Product::create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                // cleanPrice untuk menghapus koma atau titik dan di ubah menjadi decimal atau float
                'price' => $this->cleanPrice($validated['price']),
                // 'price' => $validated['price'],
                'stock' => $validated['stock'],
                'berat' => $validated['berat'],
                'image' => $image,
                'is_active' => $request->has('is_active'),
            ]);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk Berhasil Di Masukan');
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal menambahkan produk :" . $e->getMessage());
            return back()->with('error', 'Gagal Membuat Produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'berat' => 'required|integer|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $data = [
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'price' => $this->cleanPrice($validated['price']),
                // 'price' => $validated['price'],
                'berat' => $validated['berat'],
                'stock' => $validated['stock'],
                'is_active' => $request->has('is_active'),
            ];

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $content = file_get_contents($file->getRealPath());
                $extension = $file->getClientOriginalExtension();
                $base64 = base64_encode($content);
                $data['image'] = "data:image/{$extension};base64,{$base64}";
            }

            $product->update($data);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal memperbarui produk :" . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();

            // mengecek apaka produk ada yang terkait dengan pesanan
            if ($product->orderItems()->exists()) {
                throw new Exception('Tidak dapat menghapus produk dengan pesanan terkait.');
            }

            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::warning("Gagal menghapus produk :" . $e->getMessage());
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    private function cleanPrice($price)
    {
        // menghapus semua karakter selain angka (0-9) dan titik (.), lalu mengubah hasilnya menjadi tipe data float.
        return (float) preg_replace('/[^0-9.]/', '', $price);
    }
}
