@extends('layouts.layouts-admin')

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
                                {{ (new \App\Models\Order(['status' => $status]))->status }}
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
                        Ekspedisi
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Paket
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $statusBadgeClasses = [
                        'Sudah melakukan pembayaran' => ' text-blue-800   dark:text-blue-300',
                        'Pesanan sedang diproses' => 'text-orange-800 dark:text-orange-300',
                        'Pesanan sedang dikirim' => 'text-indigo-800 dark:text-indigo-300',
                    ];
                @endphp
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
                        <td class="px-6 py-4 {{ $statusBadgeClasses[$order->status] }}">
                            {{ $order->status }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->midtrans_payment_type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->ongkir->ekspedisi ?? '' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->ongkir->layanan ?? '' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <!-- Tombol Detail -->
                                <button type="button" data-modal-target="order-detail-{{ $order->id }}"
                                    data-modal-toggle="order-detail-{{ $order->id }}"
                                    class="p-2 text-blue-500 bg-transparent border border-blue-500 rounded-lg hover:bg-blue-500 hover:text-white focus:ring-2 focus:ring-blue-400 focus:bg-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>

                                <!-- Tombol Edit -->
                                <button type="button" data-modal-target="updateModal-{{ $order->id }}"
                                    data-modal-toggle="updateModal-{{ $order->id }}"
                                    class="p-2 text-green-500 bg-transparent border border-green-500 rounded-lg hover:bg-green-500 hover:text-white focus:ring-2 focus:ring-green-400 focus:bg-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 3.487a2.625 2.625 0 113.712 3.712L8.25 19.525l-4.5 1.125 1.125-4.5 12.487-12.487z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.128 6.241l-4.365-4.365" />
                                    </svg>
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
        {{-- detail order --}}
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
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Kode Resi</div>
                                <div> {{ $order->resi_code }}</div>
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
                            {{-- ongkir --}}
                            <div class="col-span-2 mt-4 ">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Ongkir</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Ekspedisi</div>
                                <div> {{ $order->ongkir->ekspedisi ?? '' }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Paket</div>
                                <div>{{ $order->ongkir->layanan ?? '' }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Biaya</div>
                                <div>Rp {{ $order->ongkir->biaya ?? '' }}</div>
                            </div>
                            <div class="col-span-2  sm:col-span-1">
                                <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Estimasi</div>
                                <div>{{ $order->ongkir->estimasi ?? '' }} hari</div>
                            </div>
                            {{-- pesanan --}}
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
                                                    Berat
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
                                                    <th scope="row"
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item->product->berat }} gram
                                                    </th>
                                                    <td class="px-6 py-4">
                                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        Rp
                                                        {{ number_format(($item->price ?? 0) * ($item->quantity ?? 0), 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    Ongkir
                                                </th>
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                </th>
                                                <td class="px-6 py-4">
                                                </td>
                                                <td class="px-6 py-4">
                                                </td>
                                                <td class="px-6 py-4">
                                                    Rp
                                                    {{ number_format($order->ongkir->biaya ?? 0, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-bold text-gray-900 dark:text-white">
                                                <th scope="row" class="px-6 py-3 text-base">Total Harga</th>
                                                <td class="px-6 py-3"></td>
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
                            style="margin-left: 38rem"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- edit --}}
        <div id="updateModal-{{ $order->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Status {{ $order->order_code }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="updateModal-{{ $order->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" action="{{ route('admin.orders.update-status', $order->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <select id="status" name="status"
                                    class="@error('status') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="" {{ old('status', $order->status) == '' ? 'selected' : '' }}>
                                        Pilih Status</option>
                                    <option value="dibayar"
                                        {{ old('status', $order->status) == 'Sudah melakukan pembayaran' ? 'selected' : '' }}>
                                        Sudah
                                        Melakukan Pembayaran
                                    </option>
                                    <option value="sedang diproses"
                                        {{ old('status', $order->status) == 'Pesanan sedang diproses' ? 'selected' : '' }}>
                                        Sedang
                                        Diproses
                                    </option>
                                    <option value="dikirim"
                                        {{ old('status', $order->status) == 'Pesanan sedang dikirim' ? 'selected' : '' }}>
                                        Pesanan
                                        Dikirim
                                    </option>
                                    <option value="terkirim"
                                        {{ old('status', $order->status) == 'Pesanan diterima' ? 'selected' : '' }}>Pesanan
                                        Diterima
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="resi_code"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kode Resi</label>
                                <input type="text" name="resi_code" value="{{ $order->resi_code }}"
                                    placeholder="Nomor Resi Wajib Diisi Ketika Status di kirim"
                                    class="@error('resi_code') border-red-500 @enderror  block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                            Edit Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach


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
