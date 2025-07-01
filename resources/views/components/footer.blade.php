{{-- footer --}}
<footer class="bg-[#E3D5CA] rounded-lg shadow-sm dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 lg:py-8 ">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('home') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <x-logo class="h-16 " />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">RD Iphone House</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="{{ route('home') }}" class="hover:underline me-4 md:me-6">Home</a>
                </li>
                <li>
                    <a href="{{ route('home') }}#service" class="hover:underline me-4 md:me-6">Service</a>
                </li>
                <li>
                    <a href="{{ route('produk') }}" class="hover:underline me-4 md:me-6">Product</a>
                </li>
                <li>
                    <button id="dropdownHoverButton" data-dropdown-toggle="dropdownHover" data-dropdown-trigger="hover"
                        class="hover:underline">Contact</button>
                    <div id="dropdownHover"
                        class="z-10 hidden bg-[#edede9] divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownHoverButton">
                            <li>
                                <a href="https://wa.me/628990543737"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">WhatsApp</a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/rd.iphone.house/"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Instagram</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2025 <a
                href="https://www.instagram.com/rd.iphone.house/" class="hover:underline">RD Iphone House</a>. All
            Rights Reserved.</span>
    </div>
</footer>
