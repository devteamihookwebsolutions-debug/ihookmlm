<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    @vite(['user/resources/js/app.js'])
    @routes
    @inertiaHead

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- ApexCharts -->
    <script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Highcharts -->
    <script defer src="https://code.highcharts.com/highcharts.js"></script>
    <script defer src="https://code.highcharts.com/maps/modules/map.js"></script>
    <script defer src="https://code.highcharts.com/maps/modules/world.js"></script>

    <!-- Others -->
    <script defer src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/confetti-js@0.1.0"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>