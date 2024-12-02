<?php

namespace App\Http\Controllers\Landing;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\RajaOngkirService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }
    public function index()
    {
        $cart = session('cart', []); // Ambil data keranjang dari session
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('landing.cart', compact('cart', 'total'));
    }

    public function store(Product $product)
    {
        $cart = session('cart', []);

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$product->id])) {
            // Tambahkan jumlah produk
            $cart[$product->id]['quantity']++;
        } else {
            // Tambahkan produk baru ke keranjang
            $cart[$product->id] = [
                'id' => $product->id,
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->image,
                "quantity" => 1
            ];
        }

        session(['cart' => $cart]); // Simpan kembali ke session

        // Redirect ke halaman keranjang dengan pesan sukses
        return redirect()->route('produk')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []); // Ambil data dari session

        if (isset($cart[$id])) {
            $quantity = $request->input('quantity');
            if ($quantity > 0) {
                $cart[$id]['quantity'] = $quantity; // Perbarui kuantitas
                session(['cart' => $cart]); // Simpan ke session
                return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diperbarui!');
            }
        }

        return redirect()->route('cart.index')->with('error', 'Produk tidak ditemukan di keranjang!');
    }

    public function destroy($id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Hapus item dari session
            session(['cart' => $cart]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
