@extends('admin::components.common.main')

@section('content')

<!-- breadcrub navs start-->
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 w-[95%] mx-auto flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black dark:text-white mb-2">{{ __('Subadmin') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                      <li class="inline-flex items-center">
                         <a href="/admin/adminhome" class="inline-flex items-center text-xs font-medium text-black hover:text-black dark:text-white dark:hover:text-white">
 <svg class="w-3 h-3 me-2.5 text-black dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
  <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd"/>
</svg>
                            {{ __('Home') }}
                        </a>
                    </li>
                    <li aria-current="page">
                      <div class="flex items-center">
                          <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                              xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 9 4-4-4-4" />
                          </svg>
                          <span class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Team') }}</span>
                      </div>
                  </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('Subadmin') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->
<!-- breadcrub navs end-->

<!-- Content area -->
<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <!--Success and Failure Messge-->
        <div class="flex p-4 mb-6 text-sm text-blue-800 rounded-lg bg-neutral-50 dark:bg-neutral-900 dark:text-blue-400 border border-blue-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3 mt-[2px]" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z">
                </path>
            </svg>
            <span class="sr-only">Info</span>
            <div>

                <div>
                    <p class="mb-2">{{ __('This tool will guide you to set up the sub-admin and its privileges.') }}</p>

                </div>
            </div>
        </div>

        <!--Row-1-->
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <!-- card -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                <div class="flex justify-end items-center mb-5">
                    <a aria-label="link" href=""
                    class="px-4 py-2 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                    <span>{{ __('Manage Roles') }}</span>
                </a>
                <a aria-label="link" href="{{ route('subadmin.add') }}"
                                class="px-4 py-2 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105">
                                <span>{{ __('Add') }}</span>
                            </a>
                </div>

                <div class="w-full mx-auto p-4">
                    <!-- Data Table -->
                    <div class="overflow-x-auto">
                        <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Admin Name') }}</th>
                                    <th>{{ __('Admin Username') }}</th>
                                    <th>{{ __('Admin Email') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {!! $show_sub_admin !!}
                            </tbody>
                        </table>

                    </div>

                </div>

                <div>
                </div>
            </div>

            <!-- card -->

</main>

@include('components.common.datatable_script')


@endsection