<div id="showupdatesubscription-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <input type="hidden" name="subscription_package_id" id="subscription_package_id" value="0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t ">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                {{ __('Update Subscription Gateway - Cannot Modify The Subscription Period Once Created') }}
                    
                </h3>
                <button type="button" onclick="closeModal('showupdatesubscription-modal')"
                    class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white"
                    >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('Close modal') }}
                        </span>
                </button>
            </div>
            <!-- Modal body -->

            <div id="showsetstripecontent" class="hidden">
                <div class="p-4 md:p-5 space-y-4 ">
                    <div class="mb-5">
                        <label for="lastname"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Billing Interval') }}</label>
                        <select id="interval_selector" name="interval_selector"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                            <option value="day">{{ __('Daily') }} </option>
                            <option value="week">{{ __('Weekly') }}</option>
                            <option value="month">{{ __('Monthly') }}</option>
                            <option value="quarter">{{ __('Every 3 months') }}</option>
                            <option value="semiannual">{{ __('Every 6 months') }}</option>
                            <option value="year">{{ __('Yearly') }}</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="lastname" class="block mb-2 text-sm font-medium text-black dark:text-white">
                        {{ __('Trial Period (Optional)') }}

                        </label>
                        <input type="number" id="trial_period_days" name="trial_period_days"
                            aria-describedby="helper-text-explanation"
                            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="" min="1" value="1" oninput="validateTrialPeriod(this)">
                        <p class="text-sm mt-2 px-2">{{ __('Days') }}
                        </p>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="flex justify-end py-6">
                    <button type="button" onclick="closeModal('showupdatestripesubscription-modal')"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
                    <button type="button" onclick="submitStripeSubButton()"
                        class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                </div>
            </div>
            <div id="showgetstripecontent" class="hidden">
                <div class="p-4 md:p-5 space-y-4 px-2 lg:px-20">
                    <div class="mb-4 flex items-center justify-between">
                        <label for="billing-interval" class="text-sm font-medium text-black dark:text-white">{{ __('Billing Interval') }}</label>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-black dark:text-white" id="stripe_interval">{{ __('day') }}</span>
                        </div>
                    </div>
                    <div class="mb-4 flex items-center justify-between">
                        <label for="trial-period" class="text-sm font-medium text-black dark:text-white" id="stripe_trial_period">{{ __('Trial Period (Optional)') }}</label>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-black dark:text-white">{{ __('1') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div id="showsetchargebeecontent" class="hidden">

                <div class="p-4 md:p-5 space-y-4 ">
                    <div class="mb-5">
                        <label for="lastname"
                            class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Billing Interval') }}</label>
                        <select id="interval_selector_chargebee" name="interval_selector_chargebee"
                            class="text-sm rounded-lg focus:ring-neutral-500 focus:border-neutral-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-neutral-500 dark:focus:border-neutral-500">
                            <option value="day">{{ __('Daily') }} </option>
                            <option value="week">{{ __('Weekly') }}</option>
                            <option value="month">{{ __('Monthly') }}</option>
                            <option value="quarter">{{ __('Every 3 months') }}</option>
                            <option value="semiannual">{{ __('Every 6 months') }}</option>
                            <option value="year">{{ __('Yearly') }}</option>
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="lastname" class="block mb-2 text-sm font-medium text-black dark:text-white">{{ __('Trial Period (Optional)') }}

                        </label>
                        <input type="number" id="trial_period_days_chargebee" name="trial_period_days_chargebee"
                            aria-describedby="helper-text-explanation"
                            class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800  dark:placeholder-neutral-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="" min="1" value="1" oninput="validateTrialPeriod(this)">
                        <p class="text-sm mt-2 px-2">{{ __('Days') }}
                        </p>
                    </div>

                </div>
                <!-- Modal footer -->
                <div class="flex justify-end py-6">
                    <button type="button" onclick="closeModal('showupdatestripesubscription-modal')"
                        class="px-5 py-2.5 me-2 mb-2 rounded bg-neutral-300 text-black dark:bg-neutral-700 dark:text-white transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Cancel') }}</button>
                    <button type="button" onclick="submitSubscriptionSubButton()"
                        class=" px-5 py-2.5 me-2 mb-2 rounded bg-neutral-800 text-white dark:bg-neutral-100 dark:text-black transition-all duration-300 shadow-md hover:scale-105"
>{{ __('Submit') }}</button>
                </div>

            </div>
            <div id="showgetchargebeecontent" class="hidden">

                <div class="p-4 md:p-5 space-y-4 px-2 lg:px-20">
                    <div class="mb-4 flex items-center justify-between">
                        <label for="billing-interval" class="text-sm font-medium text-black dark:text-white">{{ __('Billing Interval') }}</label>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-black dark:text-white" id="chargebee_interval">{{ __('day') }}</span>
                        </div>
                    </div>
                    <div class="mb-4 flex items-center justify-between">
                        <label for="trial-period" class="text-sm font-medium text-black dark:text-white" id="chargebee_trial_period">{{ __('Trial Period (Optional)') }}</label>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm font-medium text-black dark:text-white">{{ __('1') }}</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>