<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-[#edede9]">
    @include('components.navbar')

    {{-- content --}}
    {{-- <div
        class="p-4 max-w-screen-xl flex flex-col items-center justify-between mx-auto border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-5">
        @yield('content')
    </div> --}}
    @yield('content')
    {{-- end content --}}


    @yield('scripts')
</body>

</html>
