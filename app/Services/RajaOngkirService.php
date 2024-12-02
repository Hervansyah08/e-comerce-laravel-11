<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $apiKey;
    protected $url;

    public function __construct()
    {
        $this->apiKey = env('RAJA_ONGKIR_API_KEY');
        $this->url = env('RAJA_ONGKIR_URL');
    }

    // Fungsi untuk cek biaya ongkir
    public function cekOngkir($asal, $tujuan, $berat, $kurir)
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->post("{$this->url}/cost", [
            'origin' => $asal,
            'destination' => $tujuan,
            'weight' => $berat, // dalam gram
            'courier' => $kurir
        ]);

        return $response->json()['rajaongkir']['results'][0]['costs'];
    }

    // Fungsi untuk mendapatkan daftar kota
    public function getKota()
    {
        $response = Http::withHeaders([
            'key' => $this->apiKey
        ])->get("{$this->url}/city");

        return $response->json()['rajaongkir']['results'];
    }
}
