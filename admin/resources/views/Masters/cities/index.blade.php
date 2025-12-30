@extends('admin::components.common.main')
@section('content')


<div class="flex mb-4" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 rtl:space-x-reverse">
        <li class="inline-flex items-center">
            <a href="admint-board.html"
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
                    class=" text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">{{ __('Masters') }}</a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="rtl:rotate-180 w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m10 16 4-4-4-4" />
                </svg>
                <span class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Cities View') }}</span>
            </div>
        </li>
    </ol>
</div>
<main class="flex-grow">
    <div>
        @include('components.common.info_message')

        <div class="bg-white dark:bg-gray-900 border dark:border-gray-800 rounded-lg p-6 min-h-screen overflow-auto">
            <div class="flex justify-end mb-4">
                <a href="{{ route('cities.create') }}"
                    class="px-4 py-2 rounded-lg bg-gray-800 text-white dark:bg-blue-500 text-xs hover:bg-gray-900 dark:hover:bg-blue-600">
                    {{ __('Add City') }}
                </a>
            </div>

            <div class="overflow-x-auto">
                <table id="export-table" class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('City Name') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('Country') }}
                                    <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                                    </svg>
                                </span>
                            </th>
                            <th class="px-6 py-3">
                                <span class="flex items-center">
                                    {{ __('State') }}
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
                        @foreach($cities as $city)
                        <tr class="hover:bg-gray-50 text-xs dark:hover:bg-gray-800 cursor-pointer">
                            <td class="px-6 py-4">{{ $city->city_name }}</td>
                            <td class="px-6 py-4">{{ $city->country ? $city->country->country_master_name : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">{{ $city->state ? $city->state->state_name : 'N/A' }}</td>
                            <td class="px-6 py-4 flex space-x-3">
                                <a href="{{ route('cities.show', $city) }}" class="" title="View">
                                    <svg class="w-5 h-5" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"></path>
                                        <path stroke="currentColor" stroke-width="2"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('cities.edit', $city) }}" class="" title="Edit">
                                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>

                                </a>
                              <button type="button"
    class="deleteCityBtn"
    data-name="{{ $city->city_name }}"
    data-action="{{ route('cities.destroy', $city->city_id) }}"
    data-modal-target="delete-city-modal"
    data-modal-toggle="delete-city-modal"
    title="Delete">
    <svg class="w-5 h-5" aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
        viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2"
            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
    </svg>
</button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
<div id="delete-city-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-700 rounded-lg shadow w-full max-w-md">
        <div class="p-4 border-b">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                Confirm Delete
            </h3>
        </div>

        <div class="p-4">
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">
                Are you sure you want to delete the city
                "<span id="deleteCityName" class="font-semibold"></span>"?
            </p>

            <div class="flex justify-end space-x-2">
                <button data-modal-hide="delete-city-modal" type="button"
                    class="px-4 py-2 text-xs bg-gray-200 rounded-lg">
                    Cancel
                </button>

                <form id="deleteCityForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 text-xs bg-red-600 text-white rounded-lg">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
    </div>
</main>

<!-- JavaScript for Table Interactivity -->
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
    perPage: 10, // show first 10 only
    perPageSelect: [10, 25, 50, 100],
    searchable: true,
    fixedHeight: false
});
</script>

@endsection
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.deleteCityBtn');
    if (!btn) return;

    document.getElementById('deleteCityName').innerText =
        btn.dataset.name;

    document.getElementById('deleteCityForm').action =
        btn.dataset.action;
});
</script>
