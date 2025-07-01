@extends('layouts.layouts-admin')

@section('js')
    <script src="{{ asset('apexcharts/dist/apexcharts.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('apexcharts/dist/apexcharts.css') }}">
    <script>
        var options = {
            series: [{
                name: "Total Pendapatan Perbulan",
                data: @json($monthlyIncomeValues)
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Data Pendapatan Perbulan',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: @json($monthlyIncomeLabels),
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return value.toLocaleString("id-ID", {
                            style: "currency",
                            currency: "IDR",
                        });
                    }
                },
            },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection

@section('content')
    @if (session('success'))
        <x-notif-sukses> {{ session('success') }}</x-notif-sukses>
    @endif


    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

        {{-- Penjualan --}}
        <div class="bg-white p-4 rounded shadow-xl">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <!-- SVG Icon -->
                    <svg class="w-5 h-5 text-green-600 bg-[#edede9] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M8 7V6a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1h-1M3 18v-7a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
                    </svg>

                    <h3 class="text-sm text-gray-500">This month's income</h3>
                </div>
            </div>
            <p class="text-xl font-semibold">Rp {{ number_format($totalSalesThisMonth, 0, ',', '.') }}</p>
        </div>

        {{-- penjualan --}}
        <div class="bg-white p-4 rounded shadow-xl">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <!-- Icon Orders -->

                    <svg class="w-5 h-5 text-blue-600 bg-[#edede9] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                    </svg>

                    <h3 class="text-sm text-gray-500">Orders</h3>
                </div>
            </div>
            <p class="text-xl font-semibold">{{ $totalOrders }}</p>

            <!-- Order Status Boxes -->
            <div class="grid grid-cols-3 gap-2 mt-3 text-center text-xs">
                <div class="bg-gray-100 p-2 rounded">
                    <div class="text-gray-500 font-medium">Pending</div>
                    <div class="text-gray-900 text-sm font-semibold">{{ $orderStatus['pending'] }}</div>
                </div>
                <div class="bg-gray-100 p-2 rounded">
                    <div class="text-gray-500 font-medium">Processing</div>
                    <div class="text-gray-900 text-sm font-semibold">{{ $orderStatus['processing'] }}</div>
                </div>
                <div class="bg-gray-100 p-2 rounded">
                    <div class="text-gray-500 font-medium">Completed</div>
                    <div class="text-gray-900 text-sm font-semibold">{{ $orderStatus['completed'] }}</div>
                </div>
            </div>
        </div>


        <div class="bg-white p-4 rounded shadow-xl">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <!-- Icon Products -->
                    <svg class="w-5 h-5 text-purple-600 bg-[#edede9] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 12c.263 0 .524-.06.767-.175a2 2 0 0 0 .65-.491c.186-.21.333-.46.433-.734.1-.274.15-.568.15-.864a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 12 9.736a2.4 2.4 0 0 0 .586 1.591c.375.422.884.659 1.414.659.53 0 1.04-.237 1.414-.659A2.4 2.4 0 0 0 16 9.736c0 .295.052.588.152.861s.248.521.434.73a2 2 0 0 0 .649.488 1.809 1.809 0 0 0 1.53 0 2.03 2.03 0 0 0 .65-.488c.185-.209.332-.457.433-.73.1-.273.152-.566.152-.861 0-.974-1.108-3.85-1.618-5.121A.983.983 0 0 0 17.466 4H6.456a.986.986 0 0 0-.93.645C5.045 5.962 4 8.905 4 9.736c.023.59.241 1.148.611 1.567.37.418.865.667 1.389.697Zm0 0c.328 0 .651-.091.94-.266A2.1 2.1 0 0 0 7.66 11h.681a2.1 2.1 0 0 0 .718.734c.29.175.613.266.942.266.328 0 .651-.091.94-.266.29-.174.537-.427.719-.734h.681a2.1 2.1 0 0 0 .719.734c.289.175.612.266.94.266.329 0 .652-.091.942-.266.29-.174.536-.427.718-.734h.681c.183.307.43.56.719.734.29.174.613.266.941.266a1.819 1.819 0 0 0 1.06-.351M6 12a1.766 1.766 0 0 1-1.163-.476M5 12v7a1 1 0 0 0 1 1h2v-5h3v5h7a1 1 0 0 0 1-1v-7m-5 3v2h2v-2h-2Z" />
                    </svg>


                    <h3 class="text-sm text-gray-500">Products</h3>
                </div>
            </div>
            <p class="text-xl font-semibold">{{ $totalProducts }}</p>

            <!-- Product Stock Status -->
            <div class="grid grid-cols-2 gap-2 mt-3 text-center text-xs">
                <div class="bg-gray-100 p-2 rounded">
                    <div class="text-gray-500 font-medium">In Stock</div>
                    <div class="text-gray-900 text-sm font-semibold">{{ $inStock }}</div>
                </div>
                <div class="bg-red-100 p-2 rounded">
                    <div class="text-red-500 font-medium">Low Stock</div>
                    <div class="text-red-600 text-sm font-semibold">{{ $lowStock }}</div>
                </div>
            </div>
        </div>


        {{-- pembeli --}}
        <div class="bg-white p-4 rounded shadow-xl">
            <div class="flex items-center justify-between mb-1">
                <div class="flex items-center space-x-2">
                    <!-- Icon Products -->
                    <svg class="w-5 h-5 text-yellow-300 bg-[#edede9] dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M10.915 2.345a2 2 0 0 1 2.17 0l7 4.52A2 2 0 0 1 21 8.544V9.5a1.5 1.5 0 0 1-1.5 1.5H19v6h1a1 1 0 1 1 0 2H4a1 1 0 1 1 0-2h1v-6h-.5A1.5 1.5 0 0 1 3 9.5v-.955a2 2 0 0 1 .915-1.68l7-4.52ZM17 17v-6h-2v6h2Zm-6-6h2v6h-2v-6Zm-2 6v-6H7v6h2Z"
                            clip-rule="evenodd" />
                        <path d="M2 21a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1Z" />
                    </svg>
                    <h3 class="text-sm text-gray-500 mb-1">Customers</h3>
                </div>
            </div>
            <p class="text-xl font-semibold">{{ $totalCustomer }}</p>
            <p class="text-xs text-gray-500 mt-1">Active this month: {{ $Activethismonth }}</p>
        </div>
    </div>
    <div id="chart"></div>
@endsection
