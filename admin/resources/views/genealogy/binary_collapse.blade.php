@extends('admin::components.common.main')

@section('content')
          <!-- Breadcrumb -->
        <div class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/admin/dashboard"
                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                        <div class="relative w-5 h-5 flex items-center justify-center">

                            <!-- Animated Border ONLY -->
                            <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                animate-ping opacity-60"></span>

                            <!-- Static Icon -->
                            <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>

                        <a href="#"
                            class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Networks</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400"
                            aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m10 16 4-4-4-4" />
                        </svg>
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Collapse
                            View</span>
                    </div>
                </li>
            </ol>
        </div>

<!-- breadcrub navs end-->
            <main class="flex-grow">
                            <!-- card -->
                            <div
                                class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-gray-700 dark:bg-gray-800 border">
                                <div class="flex items-center justify-between space-x-4" bis_skin_checked="1">

                                    <!-- First Dropdown -->
                                    <div class="w-full max-w-xs" bis_skin_checked="1">
                                        <select id="default_matrix" name="default_matrix"
                                            class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg  block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-300">
                                            <option value="">{{ __('Select Matrix') }}</option>
                        @foreach ($defaultmatrix ?? [] as $record)
                            <option value="{{ $record['matrix_id'] }}"
                                    {{ $record['matrix_id'] == $matrixId ? 'selected' : '' }}>
                                {{ $record['matrix_name'] }}
                            </option>
                        @endforeach
                                        </select>
                                    </div>
                                </div>
                    <div class="overflow-y-auto ">
                        <div class="" data-scrollable="true" data-mobile-height="200">
                            <div class="gendata overflow-x-auto whitespace-nowrap w-auto mx-10"></div>
                        </div>
                    </div>

                 </div>
            </main>

<!-- Content area -->


@include('genealogy.components.binary_collapse_script')
@endsection
