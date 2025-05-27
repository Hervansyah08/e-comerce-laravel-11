{{-- ini untuk tampilan welcome/ tampilan  name route home --}}
@extends('layouts.layouts-landing')

@section('title', 'E-Commerce')

@section('content')


    @if (session('success'))
        <x-notif-sukses> {{ session('success') }}</x-notif-sukses>
    @endif

    <section class="bg-[#EDEDE9]">
        <div class="max-w-screen-xl mx-auto px-4 py-20 grid lg:grid-cols-2 gap-8 items-center">
            <!-- Konten Kiri -->
            <div class="text-black">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 leading-tight">
                    Upgrade Gaya Hidupmu
                </h1>
                <p class="text-lg text-gray-500 font-light mb-6">
                    Jelajahi berbagai pilihan iPhone dengan fitur canggih dan desain menawan. Temukan yang paling cocok
                    untuk kamu sekarang!
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/produk"
                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-full text-sm px-5 py-3 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                        Jelajahi Produk
                    </a>
                    {{-- <a href="#promo"
                        class="border border-white text-white font-medium px-6 py-3 rounded-lg hover:bg-white hover:text-indigo-700 transition">
                        Lihat Promo
                    </a> --}}
                </div>
            </div>

            <!-- Gambar Kanan -->
            <div class="flex justify-center">
                <img src="https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?auto=format&fit=crop&w=1170&q=80"
                    alt="iPhone Hero Image" class="w-[83%]  rounded-2xl shadow-2xl">
            </div>
        </div>
    </section>



    {{-- service --}}
    <section id="service" class="bg-[#D6CCC2] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">

                {{-- Jaminan Kualitas Terbaik --}}
                <div class="flex flex-col items-center">

                    <svg class="w-10 h-10 text-gray-700 mb-4" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3l2.122 4.243L19 8l-3.879 3.879L16.243 17 12 14.121 7.757 17l1.122-5.121L5 8l4.879-.757L12 3z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800"> Jaminan Kualitas Terbaik</h3>
                    <p class="text-sm text-gray-500 mt-2">Semua produk 100% original, bergaransi resmi, dan telah melewati
                        quality check secara menyeluruh.</p>
                </div>

                {{-- Pembayaran Aman & Terpercaya --}}
                <div class="flex flex-col items-center">
                    <svg class="w-10 h-10 text-gray-700 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 0h10.5a.75.75 0 01.75.75v8.25a.75.75 0 01-.75.75H6.75a.75.75 0 01-.75-.75V11.25a.75.75 0 01.75-.75z" />
                    </svg>

                    <h3 class="text-lg font-semibold text-gray-800">Pembayaran Aman & Terpercaya</h3>
                    <p class="text-sm text-gray-500 mt-2">Transaksi kamu dilindungi dengan sistem keamanan berlapis. Bayar
                        dengan tenang, kami jaga semuanya.</p>
                </div>

                {{-- Pengiriman Cepat & Terlacak --}}
                <div class="flex flex-col items-center">
                    <svg class="w-10 h-10 text-gray-700 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h6l2 4m-8-4v8m0-8V6a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v9h2m8 0H9m4 0h2m4 0h2v-4m0 0h-5m3.5 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm-10 0a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-800">Pengiriman Cepat & Terlacak</h3>
                    <p class="text-sm text-gray-500 mt-2">Barang dikirim dalam 24 jam! Dilengkapi dengan fitur pelacakan
                        realtime ke seluruh Indonesia.</p>
                </div>

                {{-- Layanan Pelanggan Responsif --}}
                <div class="flex flex-col items-center">

                    <svg class="w-10 h-10 text-gray-700 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 13.5V12a9 9 0 1118 0v1.5m-2.25 0a.75.75 0 00-.75.75v3a.75.75 0 00.75.75h.75a2.25 2.25 0 002.25-2.25v-1.5a.75.75 0 00-.75-.75h-.75m-15 0a.75.75 0 00-.75.75v3a.75.75 0 00.75.75h.75A2.25 2.25 0 006 17.25v-1.5a.75.75 0 00-.75-.75H4.5" />
                    </svg>

                    <h3 class="text-lg font-semibold text-gray-800">Layanan Pelanggan Responsif</h3>
                    <p class="text-sm text-gray-500 mt-2">Butuh bantuan? Tim kami siap membantu kamu setiap hari melalui
                        WhatsApp, Instagram, atau chat langsung.
                    </p>
                </div>

            </div>
        </div>
    </section>



    {{-- <div id="gallery" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg " style="height: 33rem">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-1.jpg"
                    class="w-full h-full object-cover" alt="">
            </div>
            <!-- Item 2 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-2.jpg"
                    class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="">
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-3.jpg"
                    class="w-full h-full object-cover" alt="">
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-4.jpg"
                    class="w-full h-full object-cover" alt="">
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="https://flowbite.s3.amazonaws.com/docs/gallery/square/image-5.jpg"
                    class="w-full h-full object-cover" alt="">
            </div>
        </div>
        <!-- Slider controls -->
        <button type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 1 1 5l4 4" />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next>
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div> --}}


@endsection
