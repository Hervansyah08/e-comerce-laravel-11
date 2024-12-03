<?php

namespace App\Http\Controllers\Landing;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        try {
            $cart = session('cart', []); // Ambil data keranjang dari session
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            return view('landing.cart', compact('cart', 'total'));
        } catch (\Exception $e) {
            Log::error("Gagal mengambil data keranjang: " . $e->getMessage());
            return back()->withErrors('Gagal memuat data keranjang: ' . $e->getMessage());
        }
    }

    public function store(Product $product)
    {
        try {
            $cart = session('cart', []);

            // Cek apakah produk sudah ada di keranjang
            if (isset($cart[$product->id])) {
                // Tambahkan jumlah produk dan update harga jika perlu
                $cart[$product->id]['quantity']++;
                $cart[$product->id]['price'] = $product->getRawOriginal('price'); // Perbarui harga jika berubah
            } else {
                // Tambahkan produk baru ke keranjang
                $cart[$product->id] = [
                    'id' => $product->id,
                    "name" => $product->name,
                    "price" => $product->getRawOriginal('price'),
                    "image" => $product->image,
                    "quantity" => 1,
                    "berat" => $product->berat,
                ];
            }

            session(['cart' => $cart]); // Simpan kembali ke session

            return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
        } catch (\Exception $e) {
            Log::error("Gagal menambahkan produk ke keranjang: " . $e->getMessage());
            return back()->withErrors('Gagal menambahkan produk ke keranjang: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Ambil data terbaru produk dari database
            $product = Product::findOrFail($id);

            $cart = session('cart', []); // Ambil data dari session

            if (isset($cart[$id])) {
                $quantity = $request->input('quantity');
                if ($quantity > 0) {
                    $cart[$id]['quantity'] = $quantity; // Perbarui kuantitas
                    $cart[$id]['price'] = $product->getRawOriginal('price'); // Perbarui harga dengan harga terbaru
                    session(['cart' => $cart]); // Simpan ke session
                    return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
                }
            }

            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang!');
        } catch (\Exception $e) {
            Log::error("Gagal memperbarui keranjang: " . $e->getMessage());
            return redirect()->route('cart.index')->withErrors('Gagal memperbarui keranjang: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $cart = session('cart', []);

            if (isset($cart[$id])) {
                unset($cart[$id]); // Hapus item dari session
                session(['cart' => $cart]);
                return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
            }

            return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang!');
        } catch (\Exception $e) {
            Log::error("Gagal menghapus produk dari keranjang: " . $e->getMessage());
            return redirect()->route('cart.index')->withErrors('Gagal menghapus produk dari keranjang: ' . $e->getMessage());
        }
    }
}
