<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Services\RajaOngkirService;

class OngkirController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function index()
    {
        $kota = $this->rajaOngkir->getKota();
        $ongkir = '';

        return view('landing.cek-ongkir', compact('kota', 'ongkir'));
    }

    public function cekOngkir(Request $request)
    {
        $asal = 306; // ID kota asal Ngawi
        $tujuan = $request->tujuan; // ID kota tujuan
        $berat = $request->berat; // Berat dalam gram
        $kurir = $request->kurir; // Kurir (jne, tiki, dll)

        try {
            // Panggil layanan cek ongkir
            $ongkir = $this->rajaOngkir->cekOngkir($asal, $tujuan, $berat, $kurir);

            // Dapatkan daftar kota
            $kota = $this->rajaOngkir->getKota();

            // Pastikan ongkir tidak null atau kosong
            if (!$ongkir) {
                throw new Exception('Tidak ada layanan pengiriman untuk pilihan ini.');
            }

            // Kembalikan tampilan dengan data kota dan ongkir
            return view('landing.cek-ongkir', compact('kota', 'ongkir'));
        } catch (Exception $e) {
            // Tangani kesalahan dan beri pesan error
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function pilihOngkir(Request $request)
    {
        $request->validate([
            'ongkir' => 'required', // Pastikan data ongkir diterima
        ]);

        $ongkir = json_decode($request->ongkir, true); // Decode JSON ongkir
        session(['ongkir' => $ongkir]); // Simpan ongkir di sesi

        return redirect()->route('cart.index')->with('success', 'Ongkir berhasil dipilih.');
    }
}
