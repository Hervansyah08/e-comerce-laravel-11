@extends('layouts.layouts-landing')

@section('title', 'E-Commerce')

@section('content')

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="toast-danger"
                class="flex lg:fixed lg:top-5 lg:right-5 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
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
                <div class="ms-3 text-sm font-normal">{{ $error }}</div>
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
        @endforeach
    @endif


    <form action="{{ route('cek-ongkir') }}" method="POST">
        @csrf
        <h1 class="text-sm mb-3 font-medium text-gray-700">Cek Ongkir</h1>

        <select id="asal" name="asal"
            class="bg-gray-50 border hidden border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5">
            <option value="306">Ngawi</option>
        </select>
        <select id="tujuan" name="tujuan"
            class="bg-gray-50 border mb-4 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Pilih Kota Tujuan</option>
            @foreach ($kota as $item)
                <option value="{{ $item['city_id'] }}">{{ $item['city_name'] }}</option>
            @endforeach
        </select>


        <select id="kuriran" name="kurir"
            class="bg-gray-50 mb-4 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option selected>Pilih Kurir</option>
            <option value="jne">JNE</option>
            <option value="tiki">TIKI</option>
            <option value="pos">POS</option>
        </select>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Cek
            Ongkir</button>
    </form>

    @if ($ongkir != '')
        <h2 class="text-lg font-bold my-2">Rincian Ongkir</h2>
        <h5 class="mb-4 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $ongkir['name'] }}
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($ongkir['costs'] as $costs)
                <div
                    class="max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{ $costs['service'] }}
                    </h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        {{ $costs['description'] }}
                    </p>
                    <ul class="space-y-2">
                        @foreach ($costs['cost'] as $detail)
                            <li class="border-t pt-2">
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Harga: <span
                                        class="font-semibold">Rp{{ number_format($detail['value'], 0, ',', '.') }}</span>
                                </p>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    Estimasi: <span class="font-semibold">{{ $detail['etd'] }} hari</span>
                                </p>
                                <!-- Form untuk memilih ongkir -->
                                <form action="{{ route('pilih-ongkir') }}" method="POST" class="mt-2">
                                    @csrf
                                    {{-- karena detail ini array dan HTML tidak mendukung penggunaan array secara langsung sebagai nilai atribut value --}}
                                    {{-- maka dibuat json --}}
                                    <input type="hidden" name="ekspedisi" value="{{ json_encode($ongkir['name']) }}">
                                    <input type="hidden" name="ongkir" value="{{ json_encode($costs) }}">
                                    <button type="submit"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Pilih
                                        Ongkir</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endif

@endsection
