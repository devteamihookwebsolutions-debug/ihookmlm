@include('admin::components.common.header')
<div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-gray-900 dark:text-gray-100">
@include('admin::components.common.sidebar')

<!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-x-hidden overflow-y-auto">
            <!-- Small Device Overlay Start -->
            <div :class="sidebarToggle ? 'block xl:hidden' : 'hidden'"
                class="fixed z-50 h-screen w-full bg-gray-900/50"></div>
@include('admin::components.common.header_main')

{{--main content---}}
<div class="mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6">
    <div class="space-y-6 dark:border-gray-100">

 @yield('content')


 {{--footer--}}
 @include('admin::components.common.footer')


