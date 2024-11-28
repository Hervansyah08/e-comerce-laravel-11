@extends('layouts.layouts-admin')

@section('content')
    @if (session('success'))
        <div id="toast-success"
            class="flex lg:fixed lg:top-20 lg:right-52 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
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
            class="flex lg:fixed lg:top-20 lg:right-52 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
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

    <!-- Header Section -->
    <div class="flex flex-wrap justify-between align-items-center mb-4">
        <h2 class="text-4xl font-bold  dark:text-white">Daftar Pesanan</h2>
    </div>

    <!-- Table Section -->
    <div class="relative overflow-x-auto">
        {{-- serach --}}
        <div class="mb-4">
            <form action="{{ route('admin.orders.index') }}" method="GET"
                class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Dropdown status -->
                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Semua Status</option>
                        @foreach (['dibayar', 'sedang diproses', 'dikirim'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Input pencarian -->
                <div>
                    <label for="search" class="sr-only">Cari Pesanan</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                        placeholder="Cari kode pesanan atau nama pengguna"
                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Tombol submit -->
                <div class="sm:col-span-2 lg:col-span-1">
                    <button type="submit"
                        class="w-full px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        Cari
                    </button>
                </div>
            </form>
        </div>



        {{-- tabel --}}
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Kode Pesanan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Pelanggan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Harga
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Metode Pembayaran
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Tanggal Pemesanan
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $order->order_code }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $order->user->name }}
                        </td>
                        <td class="px-6 py-4">
                            Rp{{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ ucfirst($order->status) }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->midtrans_payment_type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button data-modal-target="order-detail-{{ $order->id }}"
                                    data-modal-toggle="order-detail-{{ $order->id }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                                    Detail
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-folder2-open display-4 text-muted mb-2"></i>
                                <p class="text-muted">Tidak Ada Pesanan Yang Di Temukan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
    {{-- akhir tabel --}}

    <!-- Modal untuk setiap order -->
    @foreach ($orders as $order)
        {{-- <div id="order-detail-{{ $order->id }}" tabindex="-1"
            class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal h-full">
            <div class="relative w-full max-w-2xl h-full md:h-auto">
                <!-- Modal content -->
                <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Header -->
                    <div class="flex justify-between items-center p-4 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Detail Pesanan - {{ $order->order_code }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="order-detail-{{ $order->id }}">
                            <svg class="w-5 h-5" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Body -->
                    <div class="p-6 space-y-6">
                        <p><strong>Nama Pelanggan:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}</p>
                        <p><strong>Total Harga:</strong> Rp{{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                        <hr class="my-4">
                        <h4 class="font-semibold">Produk dalam Pesanan:</h4>
                        <ul class="list-disc list-inside">
                            @foreach ($order->orderItems as $item)
                                <li>
                                    {{ $item->product->name }} - {{ $item->quantity }} x
                                    Rp{{ number_format($item->product->price, 0, ',', '.') }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- Footer -->
                    <div class="flex justify-end p-4 border-t rounded-b dark:border-gray-600">
                        <button data-modal-hide="order-detail-{{ $order->id }}" type="button"
                            class="text-white bg-blue-500 hover:bg-blue-600 rounded-lg text-sm px-4 py-2">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <div id="order-detail-{{ $order->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Detail Pesanan - {{ $order->order_code }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="order-detail-{{ $order->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2 sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Status Pesanan</div>
                                <div> {{ ucfirst($order->status) }}</div>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Tanggal Pemesanan</div>
                                <div> {{ $order->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div class="col-span-2 mt-4 sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Informasi Pelanggan
                                </div>
                            </div>
                            <div class="col-span-2 mt-4 sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Informasi Pengiriman</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Nama</div>
                                <div> {{ $order->user->name }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Alamat</div>
                                <div> {{ $order->alamat_pengiriman }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email</div>
                                <div> {{ $order->user->email }}</div>
                            </div>
                            <div class="col-span-2">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    No HP</div>
                                <div> {{ $order->user->phone }}</div>
                            </div>
                            <div class="col-span-2 mt-4 ">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Informasi Pembayaran</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    ID Transaksi</div>
                                <div> {{ $order->midtrans_transaction_id }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Metode Pembayaran</div>
                                <div> {{ $order->midtrans_payment_type }}</div>
                            </div>
                            <div class="col-span-2 mt-4 ">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Pesanan</div>
                            </div>
                            <div class="col-span-2 ">
                                <div class="relative overflow-x-auto">
                                    <table
                                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">
                                                    Produk
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Harga
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Jumlah
                                                </th>
                                                <th scope="col" class="px-6 py-3">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->orderItems as $item)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->product->name }}
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        Rp{{ number_format($item->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-bold text-gray-900 dark:text-white">
                                                <th scope="row" class="px-6 py-3 text-base">Total</th>
                                                <td class="px-6 py-3"></td>
                                                <td class="px-6 py-3"></td>
                                                <td class="px-6 py-3">Rp
                                                    {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>

                            </div>

                        </div>
                        <button type="submit" data-modal-hide="order-detail-{{ $order->id }}"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- edit modal category --}}
    {{-- @foreach ($products as $product)
        <div id="updateModal-{{ $product->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Buat Produk Baru {{ $product->name }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="updateModal-{{ $product->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" action="{{ route('admin.products.update', $product->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name"
                                    class="@error('name') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Nama Produk" name="name" value="{{ old('name', $product->name) }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="price"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
                                <input type="number" name="price" id="price"
                                    value="{{ old('price', $product->price) }}"
                                    class="@error('price') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="$2999" required="">
                                @error('price')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="category_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select id="category_id" name="category_id"
                                    class=" @error('category_id') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option selected="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="stock"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stok</label>
                                <input type="number" id="stock" name="stock"
                                    value="{{ old('stock', $product->stock) }}"
                                    class="@error('stock') border-red-500 @enderror bg-gray-50 border text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="" required="">
                                @error('stock')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="file_input">Foto</label>
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-thumbnail"
                                        style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="https://via.placeholder.com/100" alt="No Image" class="img-thumbnail">
                                @endif
                                <input
                                    class="@error('image') border-red-500 @enderror block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="file_input" type="file" name="image" accept="image/*">
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                    Produk</label>
                                <textarea id="description" rows="4"
                                    class="@error('description') border-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Deskripsi Produk" name="description">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2 mb-1">
                                <input type="checkbox" id="is_active" name="is_active"
                                    id="is_active{{ $product->id }}"
                                    {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                    class="form-checkbox rounded">
                                <label for="is_active{{ $product->id }}"
                                    class="ml-2 text-sm font-medium text-gray-700">Aktifkan
                                    Produk</label>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Edit Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach --}}


    <script>
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
