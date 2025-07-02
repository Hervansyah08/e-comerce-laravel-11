{{-- @if ($orders->count() > 0)
    @foreach ($orders as $index => $order)
        @php
            $notifId = 'orderNotification_' . $index;
        @endphp

        @if ($order->status == 'Pesanan sedang diproses')
            <div id="{{ $notifId }}"
                class="flex lg:fixed lg:right-5 lg:top-{{ 20 + $index * 100 }} items-center w-full max-w-xs border border-yellow-300 p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 transition-opacity duration-500"
                role="alert">
                <div class="ms-3 text-sm font-normal">📦 Pesanan Anda Sedang Diproses.</div>
                <button type="button" onclick="closeNotification('{{ $notifId }}')"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @elseif ($order->status == 'Pesanan sedang dikirim')
            <div id="{{ $notifId }}"
                class="flex lg:fixed lg:right-5 lg:top-{{ 40 + $index * 70 }} items-center w-full max-w-xs border border-blue-300 p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 transition-opacity duration-500"
                role="alert">
                <div class="ms-3 text-sm font-normal">🚚 Pesanan Anda Sedang Dikirim.</div>
                <button type="button" onclick="closeNotification('{{ $notifId }}')"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
    @endforeach

    <script>
        // Auto dismiss semua notifikasi dalam 5 detik
        setTimeout(function() {
            document.querySelectorAll('[id^="orderNotification_"]').forEach(function(notif) {
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            });
        }, 7000);

        // Manual close button
        function closeNotification(id) {
            const notif = document.getElementById(id);
            if (notif) {
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            }
        }
    </script>
@endif --}}




@if ($orders->count() > 0)
    @foreach ($orders as $order)
        @php
            $notificationId = 'orderNotification-' . $order->id;
        @endphp

        @if ($order->status == 'Pesanan sedang diproses')
            <div id="{{ $notificationId }}"
                class="flex lg:fixed lg:top-20 lg:right-5 items-center w-full max-w-xs border border-yellow-300 p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div class="ms-3 text-sm font-normal">📦 Pesanan Anda Sedang Diproses.
                    <a href="{{ route('user.orders.history') }}" class="ml-2 underline font-semibold">Lihat Detail</a>
                </div>
                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#{{ $notificationId }}" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @elseif ($order->status == 'Pesanan sedang dikirim')
            <div id="{{ $notificationId }}"
                class="flex lg:fixed lg:top-44 lg:right-5 items-center w-full max-w-xs border border-blue-300 p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                role="alert">
                <div class="ms-3 text-sm font-normal">🚚 Pesanan Anda Sedang Dikirim.
                    <a href="{{ route('user.orders.history') }}" class="ml-2 underline font-semibold">Lihat Detail</a>
                </div>

                <button type="button"
                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                    data-dismiss-target="#{{ $notificationId }}" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif
    @endforeach

    <script>
        // Auto hide after 5 seconds
        setTimeout(function() {
            document.querySelectorAll('[id^="orderNotification-"]').forEach(function(notif) {
                notif.style.opacity = '0';
                setTimeout(() => notif.remove(), 500);
            });
        }, 5000);

        // Manual close button
        document.querySelectorAll('[data-dismiss-target]').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetSelector = button.getAttribute('data-dismiss-target');
                const targetElement = document.querySelector(targetSelector);
                if (targetElement) {
                    targetElement.style.opacity = '0';
                    setTimeout(() => targetElement.remove(), 500);
                }
            });
        });
    </script>
@endif
