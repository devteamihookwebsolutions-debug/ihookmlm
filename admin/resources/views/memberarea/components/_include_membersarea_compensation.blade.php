<div class="hidden" id="compensation" role="tabpanel" aria-labelledby="compensation-tab">
    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">{{ __('Compensation') }}</h3>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="compensation"
                data-tabs-toggle="#compensation-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="commissionreport-info-tab" data-tabs-target="#commissionreport-info" type="button"
                        role="tab" aria-controls="commissionreport-info"
                        aria-selected="true">{{ __('Commission Reports') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button onclick="getProcessedEarn();"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="earnings-info-tab" data-tabs-target="#earnings-info" type="button" role="tab"
                        aria-controls="earnings-info"
                        aria-selected="false">{{ __('Processed Earnings Report') }}</button>
                </li>

            </ul>
        </div>
        <div id="compensation-tab-content">
            <div  id="commissionreport-info" role="tabpanel"
                aria-labelledby="commissionreport-info-tab" >
                
                <table id="commission-report-table">
                    <thead>
                        <tr>
                            <th>
                                <span class="flex items-center">
                                    {{ __('S.No') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Amount') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Description') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Date') }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="commission_list">
                    </tbody>
                </table>

            </div>
            <div class="hidden" id="earnings-info" role="tabpanel"
                aria-labelledby="earnings-info-tab">
                
                <table id="earnings-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                    <thead>
                        <tr>
                            <th>
                                <span class="flex items-center">
                                    {{ __('S.No') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Amount') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Status') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Description') }}
                                </span>
                            </th>
                            <th>
                                <span class="flex items-center">
                                    {{ __('Date') }}
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="processed_earning">

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>