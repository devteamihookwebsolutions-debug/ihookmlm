
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ihook admin-dashboard</title>
  <link rel="icon" href="{{asset('img/ilogo.png')}}" />

   <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('css/flowbite.min.css') }}"> -->
     <link rel="stylesheet" href="{{ asset('css/flowbite.mins.css') }}">

    <meta content="" name="description" />
    <meta content="@" name="twitter:site" />
    <meta content="@" name="twitter:creator" />
    <meta content="summary_large_image" name="twitter:card" />
    <meta content="" name="twitter:title" />
    <meta content="" name="twitter:description" />
    <meta content="" name="twitter:image" />
    <meta content="#" property="og:url" />
    <meta content="en_US" property="og:locale" />
    <meta content="website" property="og:type" />
    <meta content="" property="og:site_name" />
    <meta content="" property="og:title" />
    <meta content="" property="og:description" />
    <meta content="follow, index" name="robots" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="#" rel="canonical" />
    <!--Include prism-js-->
  <script src="{{ asset('js/tailwind.min.js') }}" ></script>
    <link rel="stylesheet" href="{{ asset('css/stylex.css') }}">
    <script src="{{asset('js/simple-datatables@9.0.js')}}"></script>
    <script src="{{ asset('js/flowbite.min.js') }}" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

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
    <!-- ===== Preloader End ===== -->

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('layout', {
            sidebarLocked: false,
        });
    });
</script>
