<div class="hidden" id="transaction" role="tabpanel" aria-labelledby="transaction-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Transaction') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="transaction-tabs"
                data-tabs-toggle="#transaction-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button 
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="transaction-info-tab" data-tabs-target="#transaction-info" type="button" role="tab"
                        aria-controls="transaction-info" aria-selected="true" onclick="transaction();">
                        {{ __('Transaction') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="transaction-history-tab" data-tabs-target="#transaction-history" type="button"
                        role="tab" aria-controls="transaction-history" aria-selected="false"
                        onclick="userdetailswithdrawal();">
                        {{ __('Withdrawal') }}
                    </button>
                </li>
                <!-- PV Tab -->
                <li class="me-2" role="presentation">
                    <button 
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="pv-tab" data-tabs-target="#pv" type="button" role="tab" aria-controls="pv"
                        aria-selected="false" onclick="showuserdeatilspv();">
                        {{ __('PV') }}
                    </button>
                </li>
                <!-- Fund Transferred Tab -->
                <li class="me-2" role="presentation">
                    <button 
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="fund-transferred-tab" data-tabs-target="#fund-transferred" type="button" role="tab"
                        aria-controls="fund-transferred" aria-selected="false" onclick="showuserfundtransfer();">
                        {{ __('Fund Transferred') }}
                    </button>
                </li>
            </ul>
        </div>
        <div id="transaction-tab-content">
            <div  id="transaction-info" role="tabpanel"
                aria-labelledby="transaction-info-tab">
               
                <table id="transaction-table" class="mt-5">
                    <thead>
                        <tr>
                            <th><span class="flex items-center"> {{ __('Date') }}</span>
                            </th>
                            <th><span class="flex items-center">
                                    {{ __('Description') }}</span>
                            </th>
                            <th><span class="flex items-center"> {{ __('Amount') }}</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody id="showtransaction"> </tbody>
                </table>
            </div>

            <div class="hidden" id="transaction-history" role="tabpanel"
                aria-labelledby="transaction-history-tab">
               
                <table id="transaction-pay-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('S.No') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Amount Requested') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Account Details') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Status') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Request Date') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="showwithdrawal">
                    </tbody>
                </table>
            </div>
            <!-- PV Content -->
            <div class="hidden" id="pv" role="tabpanel"
                aria-labelledby="pv-tab">
                
                <table id="transaction-history-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                    <thead>
                        <tr>
                            <th><span class="flex items-center">{{ __('Date') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('Description') }}</span>
                            </th>
                            <th><span class="flex items-center">{{ __('PV') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="showpv">
                    </tbody>
                </table>
            </div>
            <!-- Fund Transferred Content -->
            <div class="hidden" id="fund-transferred" role="tabpanel"
                aria-labelledby="fund-transferred-tab">
               
                <table id="transaction-fund-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                    <thead>
                        <tr>
                            <th><span class="flex items-center"> {{ __('Distributors') }}</span>
                            </th>
                            <th><span class="flex items-center"> {{ __('Amount') }}</span>
                            </th>
                            <th><span class="flex items-center"> {{ __('Date') }}</span>
                            </th>

                        </tr>
                    </thead>
                    <tbody id="showfundtransfer">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
