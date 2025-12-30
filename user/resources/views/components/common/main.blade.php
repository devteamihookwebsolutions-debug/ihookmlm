{{-- resources/views/components/common/main.blade.php --}}

{{-- Main Layout Includes --}}
@include('user::components.common.header')
@include('user::components.common.sidebar')
@include('user::components.common.header_main')

    <div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
            <div class="space-y-6 dark:border-gray-100">
    {{-- Page Content --}}
    @yield('content')

{{-- Footer --}}
@include('user::components.common.footer')

