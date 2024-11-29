@extends('layouts.layouts-landing')

@section('title', 'E-Commerce')

@section('content')
    <div class="container mx-auto ">
        <h1 class="text-3xl font-semibold mb-6">Produk</h1>

        <!-- Filter & Sort -->
        <div class="mb-4">
            <form action="{{ route('produk') }}" method="GET" class="flex flex-wrap items-center  gap-3">
                <!-- Search Input -->
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                    class="border px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500 w-full sm:w-1/4 md:w-1/4">

                <!-- Category Select -->
                <select name="category"
                    class="border px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500 w-full sm:w-1/4 md:w-1/4">
                    <option value="">Pilih Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <!-- Sort Select -->
                <select name="sort"
                    class="border px-4 py-2 rounded-md focus:ring-2 focus:ring-blue-500 w-full sm:w-1/4 md:w-1/4">
                    <option value="">Urutkan</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke Tinggi
                    </option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke
                        Rendah</option>
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                </select>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full sm:w-auto">
                    Filter
                </button>
            </form>

        </div>

        <!-- Produk List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                        class="w-full h-48 object-cover rounded-md mb-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 mb-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <p class="text-gray-500 text-sm mb-4">{{ Str::limit($product->description, 45) }}</p>

                    <div class="flex justify-between items-center">
                        <button data-modal-target="order-detail-{{ $product->id }}"
                            data-modal-toggle="order-detail-{{ $product->id }}"
                            class="text-blue-500 hover:underline">Lihat
                            Detail</button>

                        <form action="" method="POST">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 lg:px-3 rounded-md hover:bg-blue-600">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- detail produk --}}
    @foreach ($products as $product)
        <div id="order-detail-{{ $product->id }}" tabindex="-1"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            Detail Produk
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="order-detail-{{ $product->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 grid grid-cols-1 sm:grid-cols-2">
                        <img class="mb-3 sm:mb-0 h-auto max-w-lg rounded-lg" src="{{ $product->image }}"
                            alt="{{ $product->name }}">
                        <div>
                            <h2 class="text-2xl mb-2 font-semibold dark:text-white">{{ $product->name }}</h2>
                            <p class=" text-lg mb-2 text-gray-500 font-semibold dark:text-gray-400">
                                Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            <p class=" text-base mb-4 text-gray-500">{{ $product->description }}</p>
                            <button type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="w-3.5 h-3.5 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 18 21">
                                    <path
                                        d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                                </svg>
                                Masukan Keranjang
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection