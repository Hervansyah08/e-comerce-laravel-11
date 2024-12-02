@extends('layouts.layouts-landing')

@section('title', 'E-Commerce')

@section('content')
    @if (session('success'))
        <div id="toast-success"
            class="flex lg:fixed lg:top-20 lg:right-5 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <span class="sr-only">Check icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-success" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @elseif(session('error'))
        <div id="toast-danger"
            class="flex lg:fixed lg:top-20 lg:right-5 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert">
            <div
                class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                </svg>
                <span class="sr-only">Error icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">{{ session('error') }}</div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                data-dismiss-target="#toast-danger" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    @endif


    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="flex-1">
                @forelse ($cart as $item)
                    <div class="flex items-center justify-between p-4 bg-white shadow-md rounded-lg mb-4">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                class="w-20 h-20 rounded-md object-cover">
                            <div>
                                <h2 class="text-lg font-medium">{{ $item['name'] }}</h2>
                                <p class="text-sm text-gray-500">{{ $item['category'] ?? '' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center space-x-4">
                            <form method="POST" action="{{ route('cart.update', $item['id']) }}"
                                class="flex items-center ms-14 md:ms-0 space-x-2">
                                @csrf
                                <button type="submit"
                                    class="decrement px-2 py-1 border rounded text-gray-600 hover:bg-gray-100">-</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                    class="quantity-input w-16 text-center border rounded-md">
                                <button type="submit"
                                    class="increment px-2 py-1 border rounded text-gray-600 hover:bg-gray-100">+</button>
                            </form>
                            <p class="font-semibold translate-y-4 sm:translate-y-0">
                                Rp{{ number_format($item['price'], 0, ',', '.') }}</p>
                            <form action="{{ route('cart.destroy', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-600 translate-y-5 sm:translate-y-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500  text-center">Keranjang belanja Anda kosong. <a href="{{ route('produk') }}"
                            class="text-blue-500 hover:underline">Lanjutkan belanja.</a>.</p>
                @endforelse

                {{-- informasi pengiriman --}}
                @if ($cart)
                    <div id="form-detail-pengiriman" class=" mt-4">
                        <h1 class="text-xl mb-3">Informasi Pengiriman</h1>
                        <form action="">
                            <div class="grid md:grid-cols-2 md:gap-6 mb-4">
                                <input type="text" id="nama" name="nama"
                                    class="block w-full p-2 mt-2 border border-gray-300 rounded-lg"
                                    placeholder="Masukkan Nama Lengkap" required />
                                <input type="text" id="telepon" name="telepon"
                                    class="block w-full p-2 mt-2 border border-gray-300 rounded-lg"
                                    placeholder="Masukkan nomor telepon" required />
                            </div>
                            <textarea id="alamat" rows="4" name="alamat"
                                class="block p-2.5 mb-4 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Detail Alamat (Cth:Blok)"></textarea>
                            {{-- <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cek</button> --}}
                        </form>
                    </div>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <p>Subtotal</p>
                            <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between">
                            <p>Ongkir</p>
                            @if (session('ongkir'))
                                <p>Rp {{ number_format(session('ongkir')['value'], 0, ',', '.') }}</p>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <p>Estimasi</p>
                            @if (session('ongkir'))
                                <p>{{ session('ongkir')['etd'] }} hari</p>
                            @endif
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="flex justify-between font-semibold">
                        <p>Total</p>
                        <p>Rp {{ number_format($total + (session('ongkir')['value'] ?? 0), 0, ',', '.') }}</p>
                    </div>
                    @guest
                        <a href="{{ route('login') }}"
                            class="block mt-6 text-center bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                            Login to Checkout
                        </a>
                    @else
                        <a href="{{ session('ongkir') ? route('cart.index') : route('ongkir.index') }}">
                            <button id="btn-pembayaran"
                                class="block mt-6 text-center bg-green-500 text-white py-2 rounded-lg hover:bg-green-600 cursor-pointer w-full">
                                {{ session('ongkir') ? 'Lanjutkan ke Pembayaran' : 'Pilih Ongkir' }}
                            </button>
                        </a>
                    @endguest

                </div>
                <a href="{{ route('produk') }}" class="block mt-4 text-center text-green-500 hover:underline">
                    &larr; Lanjutkan Belanja
                </a>
            </div>
        </div>
    </div>


    <script>
        // form pengiriman
        // document.addEventListener("DOMContentLoaded", function() {
        //     const button = document.getElementById("btn-pembayaran");
        //     const form = document.getElementById("form-detail-pengiriman");
        //     let step = 1;

        //     button.addEventListener("click", function() {
        //         if (step === 1) {
        //             // Tampilkan form detail pengiriman
        //             form.classList.remove("hidden");
        //             button.textContent = "Bayar Sekarang";
        //             step++;
        //         } else if (step === 2) {
        //             // Arahkan ke halaman pembayaran
        //             window.location.href = "/halaman-pembayaran"; // Ganti dengan URL pembayaran
        //         }
        //     });
        // });

        document.addEventListener('DOMContentLoaded', () => {
            // Tombol increment
            document.querySelectorAll('.increment').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('form').querySelector('.quantity-input');
                    const currentValue = parseInt(input.value) || 0;
                    input.value = currentValue + 1;
                });
            });

            // Tombol decrement
            document.querySelectorAll('.decrement').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.closest('form').querySelector('.quantity-input');
                    const currentValue = parseInt(input.value) || 0;
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });
            });
        });


        // Menutup notifikasi setelah 4 detik
        setTimeout(function() {
            // Menyembunyikan notifikasi success
            let successToast = document.getElementById('toast-success');
            if (successToast) {
                successToast.style.display = 'none';
            }

            // Menyembunyikan notifikasi error
            let errorToast = document.getElementById('toast-danger');
            if (errorToast) {
                errorToast.style.display = 'none';
            }
        }, 4000); // 4 detik
    </script>
@endsection
