@extends('user::components.common.main')
@section('content')
<!-- breadcrub navs start-->
<div class="py-5 lg:py-1">
    <div class="flex justify-between items-center py-3 flex-wrap w-[95%] mx-auto">
        <div class="me-5 mb-5 lg:mb-0">
            <h2 class="text-lg font-medium text-black mb-2  dark:text-white">{{ __('My E-Pins') }}</h2>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
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
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-neutral-400 mx-1" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ms-1 text-xs font-medium text-black md:ms-2 dark:text-white">{{ __('My E-Pins') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- breadcrub navs end-->

<main class="flex-grow">
    <div class="w-[95%] mx-auto px-4 sm:px-6 lg:px-0 py-6 lg:py-3">

        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5">
            <div
                class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab"
                        data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-black hover:text-black dark:text-white dark:hover:text-black border-neutral-600 dark:border-neutral-500"
                        data-tabs-inactive-classes="text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        role="tablist">
                        <li class="me-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-styled-tab"
                                data-tabs-target="#default-group" type="button" role="tab" aria-controls="profile"
                                aria-selected="false">Used</button>
                        </li>
                        <li class="me-2" role="presentation">
                            <button
                                class="inline-block p-4 border-b-2 rounded-t-lg hover:text-black hover:border-neutral-300 dark:hover:text-neutral-300"
                                id="dashboard-styled-tab" data-tabs-target="#personal-group" type="button" role="tab"
                                aria-controls="dashboard" aria-selected="false">Unused</button>
                        </li>

                    </ul>
                </div>

                <div id="default-styled-tab-content">
                    <div class="p-4 rounded-lg " id="default-group" role="tabpanel"
                        aria-labelledby="profile-tab">

                        <div
                            class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                            <div class="w-full mx-auto p-4">
                                <!-- Filter Section -->
                                <!-- Filter Section End -->

                                <!-- Data Table -->
                                <div class="overflow-x-auto">
                                    <table id="data-table" class="min-w-full divide-y divide-neutral-200">
                                        <thead>
                                            <tr>
                                                <th>{{ __('S.No') }} </th>
                                                <th>{{ __('E-Pin') }}</th>
                                                <th>{{ __('AMOUNT') }}({{session('matrix.site_currency')}})</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Used By') }}</th>
                                                <th>{{ __('Created On') }}</th>
                                                <th>{{ __('Used On') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {!! $epinusedrecords !!}
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="hidden p-4 rounded-lg " id="personal-group" role="tabpanel"
                        aria-labelledby="dashboard-tab">
                        <div
                            class="bg-white rounded-lg shadow-sm p-6 mb-5 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">

                            <div class="w-full mx-auto p-4">
                                <!-- Filter Section -->
                                <!-- Filter Section End -->

                                <!-- Data Table -->
                                <div class="overflow-x-auto">
                                    <table id="data-table2" class="min-w-full divide-y divide-neutral-200">
                                        <thead>
                                            <tr>
                                                <th>{{ __('S.No') }} </th>
                                                <th>{{ __('E-Pin') }}</th>
                                                <th>{{ __('AMOUNT') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Created On') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {!! $epinrecords !!}
                                        </tbody>
                                    </table>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>
<script>
const table2 = new simpleDatatables.DataTable("#data-table2", {
    tableRender: (_data, table, type) => {
        if (type === "print") {
            return table
        }
        const tHead = table.childNodes[0]
        const filterHeaders = {
            nodeName: "TR",
            attributes: {
                class:"search-filtering-row text-black dark:text-white bg-white dark:bg-neutral-900"
            }
        }
        tHead.childNodes.push(filterHeaders)
        return table
    }
});
</script>

@include('components.common.datatable_script')
@endsection
