<!doctype html>
<html lang="en">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
       MLM_project
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('img/ilogo.png') }}">
    <link rel="stylesheet" href="{{ asset('css/stylex.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('css/all.min.css') }}"> -->
    <!-- <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css"> -->
    <!-- <link href="{{ asset('css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.min.css') }}" id="custom-style" rel="stylesheet" type="text/css"> -->
    <script src="{{ asset('css/tailwind.min.css') }}"></script>
    <link href="{{ asset('css/flowbite.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/flowbite.min.js') }}"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/prism.min.css') }}">
    <!-- Include custom-style -->
    <!-- <link href="{{ asset('css/custom.css') }}" rel="stylesheet" /> -->
    <!--Include apex-charts-->
    <script src="{{asset('js/simple-datatables@9.0.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
        <!-- worldmap graph -->
    <script src="{{ asset('/js/d3.min.js') }}"></script>
    <script src="{{ asset('/js/topojson.min.js') }}"></script>
    <script src="{{ asset('/js/datamaps.world.min.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <style>
        {
            overflow-y: scroll;
        }
    </style>

     <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <style>
        .stocksSlider .swiper-slide {
            width: 100% !important;
        }
    </style>


</head>
<body
     x-data="{ page: 'saas', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    class="bg-gray-50 dark:bg-gray-900 dark:text-gray-100">

    <!-- ===== Preloader Start ===== -->
    <div x-show="loaded"
        x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
        class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-gray-900">
        <div class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent">
        </div>
    </div>
