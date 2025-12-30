<div id="packagelevelcommissions-modal" tabindex="-1" aria-hidden="true"
                                                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div
  class="relative bg-white rounded-lg shadow dark:bg-gray-700">            <!-- Modal header -->
            <div
                                                                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">

                <h3 class="text-xl font-semibold text-black dark:text-white">
                {{ __('Package Level Commission') }}
                    </h3>
                <button type="button" onclick="closeModal('packagelevelcommissions-modal')"
                                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">

                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6">
                        </path>
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}</span>
                </button>
            </div>
            <!-- Modal body -->

            <div class="space-y-4">

                <div class="mb-5">

                    <!-- level-commission Table with Modal -->
                    <div id="level_on_fields" class="mt-5">
                        <div class="form-submit" id="levelcommission">

                            <!-- Main Modal -->
                            <div id="level-modal" tabindex="-1" aria-hidden="true" class="">
                                <div class="relative p-4 w-full max-w-5xl max-h-full">
                                    <!-- Modal content -->
                                    <!-- Modal header -->

                                    <div class="">
                                        <div class="flex justify-end mb-10">
                                            <button id="add-button"
                                                                                                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">

                                                {{ __('Add') }}
                                            </button>
                                        </div>
                                        <div
                                            class="datatable-wrapper datatable-loading no-footer searchable fixed-columns">

                                            <div class="datatable-container">
                                                <table id="search-table" class="datatable-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%;">
                                                                <span class="flex items-center">
                                                                {{ __('Levels') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 25%;">
                                                                <span class="flex items-center">
                                                                {{ __('Name') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 20%;">
                                                                <span class="flex items-center">
                                                                {{ __('Commission') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 25%;">
                                                                <span class="flex items-center">
                                                                {{ __('Method') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 25%;">
                                                                <span class="flex items-center">
                                                                {{ __('Wallet') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 15%;">
                                                                <span class="flex items-center">
                                                                {{ __('Edit') }}

                                                                </span>
                                                            </th>
                                                            <th style="width: 15%;">
                                                                <span class="flex items-center">
                                                                {{ __('Delete') }}

                                                                </span>
                                                            </th>

                                                        </tr>
                                                    </thead>
                                                    <tbody id="package-level-table-body">
                                                        <tr id="no-data-row">
                                                            <td colspan="7" class="px-6 py-4 text-center">
                                                            {{ __('No data available') }}</td>
                                                        </tr>
                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                    <!-- Modal footer -->

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

