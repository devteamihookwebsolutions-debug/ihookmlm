<div class="hidden" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Invoice') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="invoice-tabs"
                data-tabs-toggle="#invoice-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button onclick="invoice();"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="commission-info-tab" data-tabs-target="#commission-info" type="button" role="tab"
                        aria-controls="commission-info" aria-selected="true">
                        {{ __('Commission') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button onclick="showpackagedetails();"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="purchase-history-tab" data-tabs-target="#purchase-history" type="button" role="tab"
                        aria-controls="purchase-history" aria-selected="false">
                        {{ __('Purchased Package') }}
                    </button>
                </li>
            </ul>
        </div>
        <div id="invoice-tab-content">
            <div class="" id="commission-info" role="tabpanel"
                aria-labelledby="commission-info-tab">
                
                <table id="commission-table">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('S.No') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Amount') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('description') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Date') }} </span>
                            </th>
                            <th><span class="flex items-center">{{ __('View Invoice') }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="commission_invoice">
                    </tbody>
                </table>
            </div>
            <div class="hidden" id="purchase-history" role="tabpanel"
                aria-labelledby="purchase-history-tab">
                
                <table id="purchase-table">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('Plan') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Package purchase date') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Package name') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Amount') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Current Package') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('View Invoice') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="purchase_package">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
