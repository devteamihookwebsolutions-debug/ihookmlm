{{-- resources/views/components/common/main.blade.php --}}

{{-- Main Layout Includes --}}
@include('user::components.common.header_templete1')

{{-- Sidebar --}}
@include('user::components.common.sidebar_templete1')

    {{-- Page Content --}}
    @yield('content')

{{-- Footer --}}
@include('user::components.common.footer')
