<x-app-layout title="{{ $title }}">
    <x-slot name="head">
        {{-- @vite('resources/css/dashboard.css') --}}
    </x-slot>

    {{-- <x-header :active-nav="$activeNav" /> --}}

    {{ $slot }}

    {{-- <x-footer /> --}}

    <x-slot name="scripts">
        {{-- @vite('resources/css/dashboard.js') --}}
    </x-slot>
</x-app-layout>