 <section class="py-12 bg-[#F5EBE0]">
     <div class="container mx-auto px-4">
         <div class="flex justify-between items-center mb-8">
             <h2 class="text-2xl font-bold">LATEST PRODUCTS</h2>
             <a href="{{ route('produk') }}" class="text-blue-600 hover:underline">VIEW ALL</a>
         </div>

         <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
             <!-- Product Card -->
             @foreach ($products as $product)
                 <div class="group relative ">
                     <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full max-h-64 rounded-lg">
                     <div
                         class="absolute inset-0 bg-black bg-opacity-10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                         <button class="bg-white p-2 rounded-full shadow hover:bg-gray-100">
                             <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                 viewBox="0 0 24 24">
                                 <path fill-rule="evenodd"
                                     d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                                     clip-rule="evenodd" />
                             </svg>
                         </button>

                     </div>
                     <div class="mt-2 text-center">
                         <h3 class="text-sm text-gray-700">{{ $product->name }}</h3>
                         <p class="font-semibold">{{ $product->price }}</p>
                     </div>
                 </div>
             @endforeach
         </div>
     </div>
 </section>
