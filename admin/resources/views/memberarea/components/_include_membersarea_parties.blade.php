<div class="hidden" id="parties" role="tabpanel" aria-labelledby="parties-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Parties') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <table id="search-table-parties">
            <thead>
                <tr>
                    <th>
                        <span class="flex items-center">
                            {{ __('S.No') }}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            {{ __('Party ID') }}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            {{ __('Party Coupon') }}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            {{ __('Customer Name') }}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            {{ __('Date') }}
                        </span>
                    </th>
                    <th>
                        <span class="flex items-center">
                            {{ __('Status') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody id="partytab">
            </tbody>
        </table>
    </div>
</div>
