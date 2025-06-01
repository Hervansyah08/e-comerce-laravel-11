 <section class="py-12 bg-[#F5EBE0]">
     <div class="container mx-auto px-4">
         <section class="antialiased dark:bg-gray-900 ">
             <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
                 <!-- Heading & Filters -->
                 <div class="mb-4 items-end justify-between space-y-4 sm:flex sm:space-y-0 md:mb-8">
                     <div>
                         <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Latest Products
                         </h2>
                     </div>
                     <div class="md:flex md:items-center md:space-x-4">
                         <a href="{{ route('produk') }}" id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1"
                             type="button"
                             class="mt-3 md:mt-0 flex w-full items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-3 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
                             View All
                         </a>
                     </div>
                 </div>
                 <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
                     @foreach ($products as $product)
                         <div
                             class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                             <div class="h-56 w-full">
                                 <a href="{{ route('produk') }}" class="cursor-pointer">
                                     <img class="mx-auto h-full dark:hidden" src="{{ $product->image }}"
                                         alt="{{ $product->name }}" />
                                 </a>
                             </div>
                             <div class="pt-6 text-center">
                                 <a href="{{ route('produk') }}"
                                     class="cursor-pointer text-lg text-center font-semibold leading-tight text-gray-900 hover:underline dark:text-white">{{ $product->name }}</a>
                                 <div class="mt-2 ">
                                     <p
                                         class="text-xl text-center font-bold leading-tight text-gray-900 dark:text-white">
                                         Rp {{ $product->price }}</p>
                                 </div>
                             </div>
                         </div>
                     @endforeach
                 </div>
             </div>
         </section>
     </div>
 </section>
