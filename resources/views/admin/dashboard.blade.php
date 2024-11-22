@extends('layouts.layouts-admin')

@section('content')
    @if (session('success'))
        <x-notif-sukses> {{ session('success') }}</x-notif-sukses>
    @endif

    <h2 class="text-4xl font-extrabold dark:text-white">Payments tool for companies</h2>
    <p class="my-4 text-lg text-gray-500">Start developing with an open-source library of over 450+ UI components, sections,
        and pages built with the utility classes from Tailwind CSS and designed in Figma.</p>
    <p class="mb-4 text-lg font-normal text-gray-500 dark:text-gray-400">Deliver great service experiences fast - without the
        complexity of traditional ITSM solutions. Accelerate critical development work, eliminate toil, and deploy changes
        with ease.</p>
    <a href="#" class="inline-flex items-center text-lg text-blue-600 dark:text-blue-500 hover:underline">
        Read more
        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 14 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 5h12m0 0L9 1m4 4L9 9" />
        </svg>
    </a>
@endsection
