<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} ~ {{ $title }}</title>

    <!-- Scripts -->
    @vite(['resources/css/quepenny.css', 'resources/js/quepenny.js'])

    {{ $head ?? '' }}
</head>

<body class="antialiased bg-body text-body font-body">

{{ $slot }}

<x-toast/>

<x-modal-scripts />

{{ $scripts ?? '' }}

</body>
</html>
