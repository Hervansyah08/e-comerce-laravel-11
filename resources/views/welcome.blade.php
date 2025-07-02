{{-- ini untuk tampilan welcome/ tampilan  name route home --}}
@extends('layouts.layouts-landing')

@section('title', 'RD Iphone House')

@section('content')


    @if (session('success'))
        <x-notif-sukses> {{ session('success') }}</x-notif-sukses>
    @endif

    <x-order-notification-user />


    {{-- hero --}}
    @include('components.hero')

    {{-- service --}}
    @include('components.service')

    {{-- lates produk --}}
    <x-latest-products></x-latest-products>

    @include('components.footer')


@endsection
