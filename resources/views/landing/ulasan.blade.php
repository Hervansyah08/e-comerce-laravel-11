@extends('layouts.layouts-landing')

@section('title', 'RD Iphone House')

@section('content')
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Beri Ulasan untuk Pesanan #{{ $order->order_code }}</h2>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('ulasan.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Rating --}}
            {{-- Rating Bintang --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <div id="starRating" class="flex space-x-1 cursor-pointer">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg data-value="{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                            class="w-8 h-8 star text-gray-400 hover:text-yellow-400 transition">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.91c.969 0 1.371 1.24.588 1.81l-3.976 2.89a1 1 0 00-.364 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.89a1 1 0 00-1.176 0l-3.976 2.89c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.364-1.118l-3.976-2.89c-.783-.57-.38-1.81.588-1.81h4.91a1 1 0 00.95-.69l1.518-4.674z" />
                        </svg>
                    @endfor
                </div>
                {{-- input tersembunyi untuk dikirim ke server --}}
                <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', $order->rating ?? 0) }}">
                @error('rating')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>


            {{-- Ulasan --}}
            <div class="mb-4">
                <label for="ulasan" class="block text-sm font-medium text-gray-700">Ulasan</label>
                <textarea name="ulasan" id="ulasan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                    placeholder="Tulis ulasan Anda di sini...">{{ old('ulasan', $order->ulasan) }}</textarea>
                @error('ulasan')
                    <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Kirim
                    Ulasan</button>
            </div>
        </form>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');
            let currentRating = parseInt(ratingInput.value) || 0;

            // fungsi untuk menampilkan bintang aktif
            function updateStars(rating) {
                stars.forEach(star => {
                    const starValue = parseInt(star.getAttribute('data-value'));
                    if (starValue <= rating) {
                        star.classList.add('text-yellow-400');
                        star.classList.remove('text-gray-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-400');
                    }
                });
            }

            // tampilkan bintang aktif awal
            updateStars(currentRating);

            // ketika klik bintang
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const selectedRating = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = selectedRating;
                    updateStars(selectedRating);
                });
            });
        });
    </script>

@endsection
