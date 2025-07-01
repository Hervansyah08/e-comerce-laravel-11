 <nav class="bg-[#edede9] dark:bg-gray-800 antialiased">
     <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
         <div class="flex items-center justify-between">

             <div class="flex items-center space-x-8">
                 <div class="shrink-0">
                     <a href="{{ route('home') }}" title="" class="">
                         <x-logo class="block w-auto h-16  " />
                         {{-- <img class="block w-auto h-8 dark:hidden"
                             src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full.svg" alt="">
                         <img class="hidden w-auto h-8 dark:block"
                             src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/logo-full-dark.svg"
                             alt=""> --}}
                     </a>
                 </div>

                 <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                     <li>
                         <a href="{{ route('home') }}" title=""
                             class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                             Home
                         </a>
                     </li>
                     <li class="shrink-0">
                         <a href="{{ route('home') }}#service" title=""
                             class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                             Service
                         </a>
                     </li>
                     <li class="shrink-0">
                         <a href="{{ route('produk') }}" title=""
                             class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                             Product
                         </a>
                     </li>
                     <li class="shrink-0">
                         <a href="{{ route('home') }}#dropdownHoverButton" title=""
                             class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500">
                             Contact
                         </a>
                     </li>

                 </ul>
             </div>

             <div class="flex items-center lg:space-x-2">

                 <a href="{{ route('cart.index') }}"
                     class="relative inline-flex items-center py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                     <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" fill="none" viewBox="0 0 24 24">
                         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                     </svg>
                     <span class="hidden sm:flex">My Cart</span>
                     <div
                         class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-3 -end-3 dark:border-gray-900">
                         {{ count(session('cart', [])) }}</div>
                 </a>
                 @guest
                     <a href="{{ route('login') }}"
                         class="relative inline-flex items-center py-2 px-3 md:px-5 text-gray-900 rounded  md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                         <span class=" sm:flex">Login </span>
                     </a>
                     <a href="{{ route('register') }}"
                         class="relative inline-flex items-center py-2 px-2  text-gray-900 rounded  md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                         <span class=" sm:flex">Register</span>
                     </a>
                 @else
                     {{-- user --}}
                     <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button"
                         class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white">
                         <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                             height="24" fill="none" viewBox="0 0 24 24">
                             <path stroke="currentColor" stroke-width="2"
                                 d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                         </svg>
                         {{ Auth::user()->name }}
                         <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                             viewBox="0 0 24 24">
                             <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                 d="m19 9-7 7-7-7" />
                         </svg>
                     </button>

                     <div id="userDropdown1"
                         class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
                         <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
                             @role('admin')
                                 <li><a href="{{ route('admin.dashboard') }}" title=""
                                         class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                         Dashboard </a></li>
                             @endrole
                             <li><a href="{{ route('user.orders.history') }}" title=""
                                     class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                     Riwayat Pesanan </a></li>
                             {{-- <li><a href="#" title=""
                                        class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Settings </a></li>
                                <li><a href="#" title=""
                                        class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Favourites </a></li>
                                <li><a href="#" title=""
                                        class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Delivery Addresses </a></li>
                                <li><a href="#" title=""
                                        class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                        Billing Data </a></li> --}}
                         </ul>

                         <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                             <form method="POST" action="{{ route('auth.logout') }}">
                                 @csrf
                                 <button type="submit" title=""
                                     class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                     Sign Out </button>
                             </form>
                         </div>
                     </div>
                 @endguest

                 <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1"
                     aria-controls="ecommerce-navbar-menu-1" aria-expanded="false"
                     class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white">
                     <span class="sr-only">
                         Open Menu
                     </span>
                     <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                         height="24" fill="none" viewBox="0 0 24 24">
                         <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                             d="M5 7h14M5 12h14M5 17h14" />
                     </svg>
                 </button>
             </div>
         </div>

         <div id="ecommerce-navbar-menu-1"
             class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
             <ul class="text-gray-900 dark:text-white text-sm font-medium dark:text-white space-y-3">
                 <li>
                     <a href="{{ route('home') }}"
                         class="hover:text-primary-700 dark:hover:text-primary-500">Home</a>
                 </li>
                 <li>
                     <a href="{{ route('home') }}#service"
                         class="hover:text-primary-700 dark:hover:text-primary-500">Service</a>
                 </li>
                 <li>
                     <a href="{{ route('produk') }}"
                         class="hover:text-primary-700 dark:hover:text-primary-500">Product</a>
                 </li>
                 <li>
                     <a href="{{ route('home') }}#dropdownHoverButton"
                         class="hover:text-primary-700 dark:hover:text-primary-500">Contact</a>
                 </li>

             </ul>
         </div>
     </div>
 </nav>
