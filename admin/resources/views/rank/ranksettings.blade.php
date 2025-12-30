@extends('admin::components.common.main')
@section('content')

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
                    <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                </div>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>

                <a href="#"
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">Compansation</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Rank Settings</span>
            </div>
        </li>
    </ol>
</div>
<main class="flex-grow">
    <div>
        @include('components.common.info_message')

        <div class="flex p-4 mb-6 text-xs text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 border border-blue-300"
            role="alert">
            <svg class="flex-shrink-0 inline w-3 h-3 me-3 mt-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">{{ __('Info') }}</span>
            <div>
                <div class="font-semibold text-base mb-3">{{ __('Instructions') }}</div>
                <ul class="gap-3 flex flex-col">
                    <li>{{ __('This tool will help you to create Rank or Achievements as per your compensation plan') }}
                    </li>
                </ul>
            </div>
        </div>

        <div
            class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6 border border-gray-200 dark:border-gray-800">
            <div class="flex justify-end mb-4">
                <a href="/admin/ranksetting/add"
                    class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                    {{ __('Add Rank') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="export-table" class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('Plan Name') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('Rank') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('Wallet') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('Action') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! $showrank !!}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection

<script>
const exportCustomCSV = function(dataTable, userOptions = {}) {
    const clonedUserOptions = {
        ...userOptions
    };
    clonedUserOptions.download = false;
    const csv = simpleDatatables.exportCSV(dataTable, clonedUserOptions);
    if (!csv) return false;

    const defaults = {
        download: true,
        lineDelimiter: "\n",
        columnDelimiter: ";"
    };
    const options = {
        ...defaults,
        ...clonedUserOptions
    };
    const separatorRow = Array(dataTable.data.headings.filter((_heading, index) => !dataTable.columns.settings[
            index]?.hidden).length)
        .fill("+")
        .join("+");

    const str = separatorRow + options.lineDelimiter + csv + options.lineDelimiter + separatorRow;

    if (userOptions.download) {
        const link = document.createElement("a");
        link.href = encodeURI("data:text/csv;charset=utf-8," + str);
        link.download = (options.filename || "datatable_export") + ".txt";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
    return str;
};

const table = new simpleDatatables.DataTable("#export-table", {
    template: (options, dom) => `
        <div class='${options.classes.top}'>
            <div class='flex flex-col sm:flex-row sm:items-center space-y-4 sm:space-y-0 sm:space-x-3 rtl:space-x-reverse w-full sm:w-auto'>
                ${options.paging && options.perPageSelect ?
                    `<div class='${options.classes.dropdown}'>
                        <label>
                            <select class='${options.classes.selector}'></select> ${options.labels.perPage}
                        </label>
                    </div>` : ""
                }
            </div>
            ${options.searchable ?
                `<div class='${options.classes.search}'>
                    <input class='${options.classes.input}' placeholder='${options.labels.placeholder}' type='search' title='${options.labels.searchTitle}'${dom.id ? ` aria-controls='${dom.id}'` : ""}>
                </div>` : ""
            }
        </div>
        <div class='${options.classes.container}'${options.scrollY.length ? ` style='height: ${options.scrollY}; overflow-y: auto;'` : ""}></div>
        <div class='${options.classes.bottom}'>
            ${options.paging ? `<div class='${options.classes.info}'></div>` : ""}
            <nav class='${options.classes.pagination}'></nav>
        </div>
    `
});
</script>
