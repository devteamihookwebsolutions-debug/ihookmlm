<div class="hidden" id="wallet" role="tabpanel" aria-labelledby="wallet-tab">
    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">{{ __('Wallet') }}</h3>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="wallet-info"
                data-tabs-toggle="#wallet-info-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="payout-info-tab" data-tabs-target="#payout-info" type="button" role="tab"
                        aria-controls="payout-info" aria-selected="true">
                        {{ __('Payout History') }}
                    </button>
                </li>
                <li class="me-2 groe" role="presentation">
                    <button id="ewallet-info-tab"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="ewallet-info-tab" data-tabs-target="#ewallet-info" type="button" role="tab"
                        aria-controls="ewallet-info" aria-selected="false">
                        {{ __('E-Wallet History') }}
                    </button>
                </li>
            </ul>
        </div>

        <div id="wallet-info-tab-content">
            <!-- PAYOUT HISTORY -->
            <div id="payout-info" role="tabpanel"
                aria-labelledby="payout-info-tab">
                <table id="payout-table" class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3">{{ __('S.No') }}</th>
                            <th class="px-4 py-3">{{ __('Transaction ID') }}</th>
                            <th class="px-4 py-3">{{ __('Amount') }}</th>
                            <th class="px-4 py-3">{{ __('Wallet') }}</th>
                            <th class="px-4 py-3">{{ __('Account Details') }}</th>
                            <th class="px-4 py-3">{{ __('Status') }}</th>
                            <th class="px-4 py-3">{{ __('Request Date') }}</th>
                        </tr>
                    </thead>
                    <tbody id="payoutdata">
                        {{-- Filled by JS --}}
                    </tbody>
                </table>
            </div>

            <!-- E-WALLET HISTORY -->
            <div class="hidden" id="ewallet-info" role="tabpanel">
                <div class="overflow-x-auto">
                    <table id="ewallet-table" class="w-full text-sm text-left">
                        <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 py-3">{{ __('S.No') }}</th>
                                <th class="px-4 py-3">{{ __('Transaction ID') }}</th>
                                <th class="px-4 py-3">{{ __('Amount') }}</th>
                                <th class="px-4 py-3">{{ __('Description') }}</th>
                                <th class="px-4 py-3">{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="ewallet_history">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500 animate-pulse">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>