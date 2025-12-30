<div class="hidden" id="organization" role="tabpanel"
    aria-labelledby="organization-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Organization') }}</h2>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="organization-tabs"
                data-tabs-toggle="#organization-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button onclick="getGenealogyDetails();"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="genealogy-info-tab" data-tabs-target="#genealogy-info" type="button" role="tab"
                        aria-controls="genealogy-info" aria-selected="true">
                        {{ __('Genealogy') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="plandetails-tab" data-tabs-target="#plandetails" type="button" role="tab"
                        aria-controls="plandetails" aria-selected="false" onclick="getUserDeatilsPlan();">
                        {{ __('Plan Details') }}
                    </button>
                </li>
                <!-- ibo -->
                <li class="me-2" role="presentation">
                    <button onclick="getReferrals()"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="ibo-tab" data-tabs-target="#ibo" type="button" role="tab" aria-controls="ibo"
                        aria-selected="false">
                        {{ __('Personally Referred IBOs') }}
                    </button>
                </li>
                <!-- Host Party Tab -->
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="hostparty-tab" data-tabs-target="#hostparty" type="button" role="tab"
                        aria-controls="hostparty" aria-selected="false" onclick="getPartyDetail()">
                        {{ __('Host Party') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-neutral-100 hover:border-neutral-300 dark:border-neutral-700 dark:hover:text-neutral-300"
                        id="customerorg-tab" data-tabs-target="#customerorg" type="button" role="tab"
                        aria-controls="customerorg" aria-selected="false" onclick="getCustomers()">
                        {{ __('Customers') }}
                    </button>
                </li>

            </ul>
        </div>

    <div id="organization-tab-content">
    {{-- PLAN DETAILS TAB --}}
    <div  id="plandetails" role="tabpanel" aria-labelledby="plandetails-tab">

        {{-- This is where AJAX injects --}}
        <div id="showplan" class="xl:col-span-9 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Loading state -->
            <div class="col-span-2 bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500">Loading plan details...</p>
            </div>
        </div>
    </div>

    {{-- OTHER TABS (keep your existing ones) --}}
    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 hidden" id="genealogy-info" role="tabpanel" aria-labelledby="genealogy-info-tab">
        {{-- Your genealogy content --}}
    </div>

    <div class="rounded-lg bg-neutral-50 dark:bg-neutral-900 hidden" id="ibo" role="tabpanel" aria-labelledby="ibo-tab">
        {{-- Your IBO content --}}
    </div>

    {{-- ... other tabs --}}
</div>

        <div class="rounded-lg bg-gray-50 dark:bg-gray-900 hidden" id="plandetails" role="tabpanel"
            aria-labelledby="plandetails-tab">
            <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                {{ __('Plan Details') }}</h3>

            <form class="profile_form_new">
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-5" id="showplan">

                </div>
            </form>
        </div>
        <!-- savednotes Content -->
        <div class=" hidden" id="ibo" role="tabpanel"
            aria-labelledby="hostparty-tab">
            <h3 class="text-lg font-semibold text-black mb-10 dark:text-white">
                {{ __('Personally Referred IBOs') }}</h3>
            <table id="ibo-table">
                <thead>
                    <tr>
                        <th><span class="flex items-center">{{ __('SNO') }} </span></th>
                        <th><span class="flex items-center">{{ __('NAME') }}</span></th>
                        <th><span class="flex items-center">{{ __('STATUS') }}</span></th>
                        <th><span class="flex items-center">{{ __('DATE') }}</span></th>
                    </tr>
                </thead>
                <tbody id="direct_referrals">
                </tbody>
            </table>
        </div>
        <!-- ibo Content -->
        <div class=" hidden" id="hostparty" role="tabpanel"
            aria-labelledby="ibo-tab">
           
            <table id="hostparty-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                <thead>
                    <tr>
                        <th><span class="flex items-center">{{ __('SNO') }}</span></th>
                        <th><span class="flex items-center">{{ __('PARTYID') }}</span></th>
                        <th><span class="flex items-center">{{ __('PARTYCOUPON') }}</span></th>
                        <th><span class="flex items-center">{{ __('CUSTOMERNAME') }}</span></th>
                        <th><span class="flex items-center">{{ __('DATE') }}</span></th>
                        <th><span class="flex items-center">{{ __('STATUS') }}</span></th>
                    </tr>
                </thead>
                <tbody id="party_list">
                </tbody>
            </table>
        </div>

        <div class=" hidden" id="customerorg" role="tabpanel"
            aria-labelledby="customerorg-tab">
            
            <table id="customerorg-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 mt-5">
                <thead>
                    <tr>
                        <th><span class="flex items-center">{{ __('SNo') }}</span></th>
                        <th><span class="flex items-center">{{ __('Username') }}</span></th>
                        <th><span class="flex items-center">{{ __('Email') }}</span></th>
                        <th><span class="flex items-center">{{ __('Date') }}</span></th>
                        <th><span class="flex items-center">{{ __('Status') }}</span></th>
                    </tr>
                </thead>
                <tbody id="customers_list">
                </tbody>
            </table>
        </div>
    </div>
</div>



<div id="paymentmoreinformation-modal" tabindex="-1"
    class="hidden  overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Payment info') }}</h3>
                <button type="button" id="paymentmoreinformationcloseicon-modal"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                   >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Close
                        modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="view_payment_details"></div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end py-6">
                <button  type="button" id="paymentmoreinformationclose-modal"
                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>




<div id="planinfo-modal" tabindex="-1"
    class="hidden  overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
    aria-modal="true" role="dialog">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    {{ __('Plan information') }}</h3>
                <button type="button" id="planinfocloseicon-modal"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                   >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                    </svg>
                    <span class="sr-only">Close
                        modal</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div id="view_matrix_details"></div>
            </div>
            <!-- Modal footer -->
            <div class="flex justify-end py-6">
                <button  type="button" id="planinfoclose-modal"
                    class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
            </div>
        </div>
    </div>
</div>
