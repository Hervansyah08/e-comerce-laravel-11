@extends('layouts.layouts-landing')

@section('title', 'RD Iphone House')

@section('content')
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8 mb-6">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Riwayat Pesanan</h1>
            <a href="/" class="text-emerald-600 hover:text-emerald-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Lanjutkan Belanja
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="bg-[#edede9] rounded-xl shadow-sm p-1 mb-3">
            <form action="{{ route('user.orders.history') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan..."
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                </div>

                <div class="w-full sm:w-auto">
                    <select name="status"
                        class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                            Pembayaran</option>
                        <option value="dibayar" {{ request('status') == 'dibayar' ? 'selected' : '' }}>Sudah melakukan
                            pembayaran
                        </option>
                        <option value="sedang diproses" {{ request('status') == 'sedang diproses' ? 'selected' : '' }}>
                            Pesanan
                            sedang diproses
                        </option>
                        <option value="dikirim" {{ request('status') == 'dikirim' ? 'selected' : '' }}>Pesanan sedang
                            dikirim</option>
                        <option value="terkirim" {{ request('status') == 'terkirim' ? 'selected' : '' }}>Pesanan diterima
                        </option>
                        <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Pesanan
                            dibatalkan
                        </option>
                    </select>
                </div>

                <div class="w-full sm:w-auto">
                    <button type="submit"
                        class="w-full px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @php
                $statusBadgeClasses = [
                    'Menunggu pembayaran' => 'bg-amber-100 text-amber-800',
                    'Sudah melakukan pembayaran' => 'bg-blue-100 text-blue-800',
                    'Pesanan sedang diproses' => 'bg-indigo-100 text-indigo-800',
                    'Pesanan sedang dikirim' => 'bg-purple-100 text-purple-800',
                    'Pesanan diterima' => 'bg-green-100 text-green-800',
                    'Pesanan dibatalkan' => 'bg-red-100 text-red-800',
                ];
            @endphp

            @forelse ($orders as $order)
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div>
                            <div class="text-lg font-medium">Pesanan {{ $order->order_code }}</div>
                            <div class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</div>
                        </div>
                        <span
                            class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusBadgeClasses[$order->status] }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="mt-4">
                        <div class="text-sm text-gray-600">Total Pesanan:</div>
                        <div class="text-lg font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-x-4">
                        @if ($order->status == 'Pesanan sedang dikirim')
                            <button type="button" data-modal-target="confirmModal-{{ $order->id }}"
                                data-modal-toggle="confirmModal-{{ $order->id }}"
                                class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg
                            text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700
                            dark:focus:ring-blue-800"
                                type="button">
                                Pesanan Diterima
                            </button>
                        @endif
                        <button data-modal-target="order-detail-{{ $order->id }}"
                            data-modal-toggle="order-detail-{{ $order->id }}"
                            class="block text-white bg-blue-700
                            hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg
                            text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700
                            dark:focus:ring-blue-800"
                            type="button">
                            Lihat Detail
                        </button>
                    </div>
                </div>


                <!-- Modal Detail dengan Tailwind -->

                <div id="order-detail-{{ $order->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-3xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Detail Pesanan - {{ $order->order_code }}
                                </h3>
                                <button type="button"
                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="order-detail-{{ $order->id }}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
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
                                            Informasi Pengiriman
                                        </div>
                                    </div>
                                    <div class="opacity-0 col-span-2 mt-4 sm:col-span-1">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Informasi Pengiriman</div>
                                    </div>
                                    <div class="col-span-2  sm:col-span-1">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Alamat</div>
                                        <div> {{ $order->alamat_pengiriman }}</div>
                                    </div>
                                    <div class="col-span-2  sm:col-span-1">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Kode Resi</div>
                                        <div> {{ $order->resi_code ?? '-' }}</div>
                                    </div>
                                    <div class="col-span-2 mt-4 ">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Informasi Pembayaran</div>
                                    </div>
                                    <div class="col-span-2  sm:col-span-1">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            ID Transaksi</div>
                                        <div> {{ $order->midtrans_transaction_id ?? '-' }}
                                        </div>
                                    </div>
                                    <div class="col-span-2  sm:col-span-1">
                                        <div class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Metode Pembayaran</div>
                                        <div> {{ $order->midtrans_payment_type ?? '-' }}</div>
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
                                                        <tr
                                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                            <th scope="row"
                                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                                {{ $item->product->name }}
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
                                                        <td class="px-6 py-4">

                                                        </td>
                                                        <td class="px-6 py-4">

                                                        </td>
                                                        <td class="px-6 py-4">
                                                            Rp
                                                            {{ number_format($order->ongkir->biaya ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="font-bold text-gray-900 dark:text-white">
                                                        <th scope="row" class="px-6 py-3 text-base">Total Harga</th>
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
                                @if ($order->status == 'Menunggu pembayaran')
                                    <div class="flex justify-between items-center mt-4">
                                        <!-- Tombol kiri -->

                                        <form action="{{ route('orders.cancelOrder', $order->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="text-white inline-flex items-center bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                Batalkan Pesanan
                                            </button>
                                        </form>
                                        <!-- Tombol kanan -->
                                        <button data-snap-token="{{ $order->snap_token }}"
                                            class="bayar-btn text-white inline-flex items-center bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                            Bayar
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>


            @empty
                <div class="bg-white rounded-xl shadow-sm p-6 text-center text-gray-500">
                    Belum ada pesanan
                </div>
            @endforelse

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    @foreach ($orders as $order)
        <div id="confirmModal-{{ $order->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="confirmModal-{{ $order->id }}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda yakin pesanan
                            sudah diterima ?</h3>
                        <form action="{{ route('orders.received', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button data-modal-hide="popup-modal" type="submit"
                                class="text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Confirm
                            </button>
                            <button data-modal-hide="popup-modal" type="button"
                                data-modal-toggle="confirmModal-{{ $order->id }}"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @section('scripts')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
        </script>
        <script>
            document.querySelectorAll('.bayar-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const snapToken = this.dataset.snapToken;

                    snap.pay(snapToken, {
                        onSuccess: async function(result) {
                            // Kirim update ke backend
                            const response = await fetch('/checkout/update-status', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    order_id: result.order_id,
                                    transaction_id: result.transaction_id,
                                    payment_type: result.payment_type,
                                    status: 'dibayar'
                                })
                            });

                            const resJson = await response.json();
                            if (response.ok) {

                                location.reload();
                            } else {
                                alert('Gagal memperbarui status order: ' + resJson.message);
                            }
                        },
                        onPending: function(result) {

                        },
                        onError: function(result) {
                            alert('Pembayaran gagal: ' + result.status_message);
                        },
                        onClose: function() {

                        }
                    });
                });
            });
        </script>
    @endsection

@endsection
