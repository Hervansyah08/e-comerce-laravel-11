  {{-- ini desain produk yang lama --}}


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
              <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga: Rendah ke
                  Tinggi
              </option>
              <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga: Tinggi ke
                  Rendah</option>
              <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
          </select>

          <!-- Submit Button -->
          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 w-full sm:w-auto">
              Filter
          </button>
      </form>
  </div>


  <!-- Produk List -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($products as $product)
          <div class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
              <img src="{{ $product->image }}" alt="{{ $product->name }}"
                  class="w-full max-h-96 object-cover rounded-md mb-4">
              <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
              <p class="text-gray-600 mb-2">Rp {{ $product->price }}</p>
              <p class="text-gray-500 text-sm mb-4">{{ Str::limit($product->description, 45) }}</p>

              <div class="flex justify-between items-center">
                  <button data-modal-target="order-detail-{{ $product->id }}"
                      data-modal-toggle="order-detail-{{ $product->id }}" class="text-blue-500 hover:underline">Lihat
                      Detail</button>

                  <form action="{{ route('cart.store', $product->id) }}" method="POST">
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
