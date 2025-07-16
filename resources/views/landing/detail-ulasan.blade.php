@extends('layouts.layouts-landing')

@section('title', 'RD Iphone House')


@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Ulasan untuk Pesanan #{{ $order->order_code }}</h2>

        {{-- Rating (readonly) --}}
        <div class="flex items-center space-x-1 mb-4">
            @for ($i = 1; $i <= 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $order->rating ? 'currentColor' : 'none' }}"
                    viewBox="0 0 24 24" stroke="currentColor"
                    class="w-6 h-6 {{ $i <= $order->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.91c.969 0 1.371 1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.89a1 1 0 00-1.176 0l-3.976 2.89c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.89c-.783-.57-.38-1.81.588-1.81h4.91a1 1 0 00.95-.69l1.518-4.674z" />
                </svg>
            @endfor
        </div>

        {{-- Ulasan --}}
        <div class="mb-2 text-gray-800">
            <p class="text-base leading-relaxed">{{ $order->ulasan ?? 'Belum ada ulasan.' }}</p>
        </div>
    </div>
@endsection
