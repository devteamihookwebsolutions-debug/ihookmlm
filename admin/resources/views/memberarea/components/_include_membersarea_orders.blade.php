{{-- resources/views/admin/memberarea/components/_include_membersarea_orders.blade.php --}}
<div class="hidden " id="orders" role="tabpanel" aria-labelledby="orders-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Orders') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="personal"
                data-tabs-toggle="#personal-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600
                                   dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                            id="account-info-tab" data-tabs-target="#account-info" type="button"
                            role="tab" aria-controls="account-info" aria-selected="true">
                        {{ __('Personal Purchase') }}
                    </button>
                </li>
            </ul>
        </div>

        <div id="personal-tab-content">
            <div id="account-info"
                 role="tabpanel" aria-labelledby="account-info-tab">
                <table id="search-table-3" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('S.No') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Date') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Email') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Order Currency') }}
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                {{ __('Total') }}
                            </th>
                        </tr>
                    </thead>
                     <tbody id="personalpurchasetab" data-member-id="{{ $sub1 ?? '' }}">
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

