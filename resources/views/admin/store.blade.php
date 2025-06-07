@extends('layouts.layouts-admin')

@section('content')
    {{-- Modal Notifikasi --}}
    @if (session('success') || session('error'))
        <!-- Main modal -->
        <div id="crud-success-modal" tabindex="-1"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 text-center">
                    <button type="button"
                        class="absolute top-2.5 right-2.5 text-gray-400 hover:text-gray-900 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        onclick="document.getElementById('crud-success-modal').classList.add('hidden')">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div class="p-6 text-center">
                        @if (session('success'))
                            <svg class="mx-auto mb-4 w-12 h-12 text-green-500 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ session('success') }}
                            </h3>
                        @elseif (session('error'))
                            <svg class="mx-auto mb-4 w-12 h-12 text-red-500 dark:text-red-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                {{ session('error') }}
                            </h3>
                        @endif
                        <button onclick="document.getElementById('crud-success-modal').classList.add('hidden')"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <!-- Header Section -->
    <div class="flex flex-wrap justify-between align-items-center">
        <h2 class="text-4xl font-bold  dark:text-white">Profil Toko</h2>
        <button type="button"
            class="text-white mt-4 lg:mt-0 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
            data-modal-target="createCategory" data-modal-toggle="createCategory">
            Tambah Profil Toko
        </button>
    </div>

    <div class="relative overflow-x-auto mt-6">

        {{-- tabel --}}
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-center text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Gambar
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Alamat
                    </th>
                    <th scope="col" class="px-6 py-3">
                        No HP
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($stores as $store)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            @if ($store->image)
                                <img src="{{ asset('storage/' . $store->image) }}" alt="Store Image"
                                    class="w-48 h-auto rounded cursor-pointer transition-transform duration-300 hover:scale-105"
                                    onclick="openImageModal('{{ asset('storage/' . $store->image) }}')">
                            @else
                                <p>Gambar belum tersedia</p>
                            @endif
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $store->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $store->address }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $store->phone }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <!-- Tombol Edit (Background Kuning) -->
                                <button type="button" data-modal-target="updateModal-{{ $store->id }}"
                                    data-modal-toggle="updateModal-{{ $store->id }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-yellow-400 border border-yellow-400 rounded-s-lg hover:bg-yellow-500 focus:z-10 focus:ring-2 focus:ring-yellow-700 focus:bg-yellow-600">
                                    <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 17.25H6.75V13.5l9.563-9.563a1.5 1.5 0 0 1 2.122 2.122L8.25 15.75ZM19.5 6.75a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM3.75 21h16.5" />
                                    </svg>
                                    Edit
                                </button>
                                <!-- Tombol Hapus (Background Merah) -->
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-700 border border-red-700 rounded-e-lg hover:bg-red-800 focus:z-10 focus:ring-2 focus:ring-red-400"
                                    data-modal-toggle="deleteModal-{{ $store->id }}"
                                    data-modal-target="deleteModal-{{ $store->id }}">
                                    <svg class="w-5 h-5 me-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4">
                            <div class="d-flex flex-column align-items-center">
                                <i class="bi bi-folder2-open display-4 text-muted mb-2"></i>
                                <p class="text-muted">Tidak Ada Data Profil Toko</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- <div class="mt-4">
            {{ $stores->withQueryString()->links() }}
        </div> --}}
    </div>
    {{-- akhir tabel --}}

    {{-- zoom gambar --}}
    <!-- Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden"
        onclick="closeImageModal()">
        <img id="modalImage" src="" class="max-w-4xl max-h-[90vh] rounded shadow-lg">
    </div>
    {{-- end zoom gambar --}}

    {{-- add modal category --}}
    <div id="createCategory" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Buat Data Profil Toko
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="createCategory">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:p-5" action="{{ route('admin.store.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="@error('name') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Type product name">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NO
                                HP</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                class="@error('phone') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="image"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Foto</label>
                            <input
                                class="@error('image') border-red-500 @enderror block w-full text-sm text-gray-900 border rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                id="file_input" type="file" name="image" accept="image/*">
                            @error('image')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-2">
                            <label for="address"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                            <textarea id="address" rows="4" name="address"
                                class="@error('address') border-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                            @enderror
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
                        Tambahkan Data Profil Toko
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- edit modal category --}}
    @foreach ($stores as $store)
        <div id="updateModal-{{ $store->id }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Edit Profil Toko {{ $store->name }}
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="updateModal-{{ $store->id }}">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5" action="{{ route('admin.store.update', $store->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $store->name) }}"
                                    class="@error('name') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type product name">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label for="phone"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No HP</label>
                                <input type="text" name="phone" id="phone"
                                    value="{{ old('phone', $store->phone) }}"
                                    class="@error('phone') border-red-500 @enderror bg-gray-50 border  text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-span-2">
                                <label for="address"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
                                <textarea id="address" rows="4" name="address"
                                    class="@error('address') border-red-500 @enderror block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write product description here">{{ old('address', $store->address) }}</textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($store->image)
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium">Gambar Saat Ini</label>
                                    <img src="{{ asset('storage/' . $store->image) }}" alt="Store Image"
                                        class="w-full h-auto mt-2 rounded shadow cursor-pointer hover:scale-105 transition"
                                        onclick="openImageModal('{{ asset('storage/' . $store->image) }}')">
                                </div>
                            @endif

                            <!-- Upload Gambar Baru -->
                            <div class="col-span-2">
                                <label for="image" class="block text-sm font-medium">Ganti Gambar (opsional)</label>
                                <input type="file" name="image" id="image" class="mt-1">
                                @error('image')
                                    <span class="text-red-600 text-sm">{{ $message }}</span>
                                @enderror
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
                            Edit Profil Toko
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- delete category modal --}}
        <div id="deleteModal-{{ $store->id }}" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="deleteModal-{{ $store->id }}">
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
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah Anda Yakin Mengahapus
                            Profil Toko {{ $store->name }}?</h3>
                        <form action="{{ route('admin.store.destroy', $store->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button data-modal-hide="popup-modal" type="submit"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Hapus
                            </button>
                            <button data-modal-hide="popup-modal" type="button"
                                data-modal-toggle="deleteModal-{{ $store->id }}"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Batal</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        setTimeout(() => {
            const modal = document.getElementById('crud-success-modal');
            if (modal) modal.classList.add('hidden');
        }, 4000); // 3 deti

        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('modalImage');
            img.src = src;
            modal.classList.remove('hidden');
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
