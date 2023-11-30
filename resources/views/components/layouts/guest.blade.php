@props([
    'title',
    'activeNav' => null,
    'showHeaderFooter' => true
])

<x-app-layout title="{{ $title }}">
    @if($showHeaderFooter)
        <x-header :active-nav="$activeNav" />
    @endif

    {{ $slot }}

    @if($showHeaderFooter)
        <x-footer />
    @endif
</x-app-layout>