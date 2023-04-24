<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') . ' ~ ' . $title }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <livewire:styles/>

    {{ $styles ?? '' }}

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    {{ $headScripts ?? '' }}
</head>

<body class="antialiased bg-body text-body font-body">
    @if($showHeaderFooter)
        <x-header :nav="$nav" />
    @endif

    {{ $slot }}

    @if($showHeaderFooter)
        <x-footer />
    @endif

    <x-toast/>

    <livewire:scripts/>
    <x-modal-scripts/>

    {{ $bodyScripts ?? '' }}
</body>
</html>
