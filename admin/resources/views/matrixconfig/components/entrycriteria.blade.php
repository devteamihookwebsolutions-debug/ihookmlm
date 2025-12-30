<div id="entry-criteria" class="tab-content hidden">
    <h3 class="text-sm font-semibold text-gray-800 mb-10 dark:text-gray-200">{{ __('Entry Criteria') }}</h3>
    <div class="mb-5">
        <table class="min-w-2xl ">
            <tbody>
                <tr class="flex items-start">
                    <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                        {{ __('Member Account') }}
                    </td>
                    <td class="px-6  text-right ">

                        <div class="flex items-center mb-4">
                            <input type="radio"
                                class="w-4 h-4 text-gray-900 dark:text-blue-600 bg-gray-100 border-gray-300 focus:ring-gray-300 dark:focus:ring-blue-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                name="members_account_type" value="1" onclick="showMembersAccount(1);"
                                @if(($errval['members_account_type'] ?? null)==1)checked @endif>
                            <label for="default-radio-1"
                                class="ms-2 text-xs text-gray-600 dark:text-gray-300">{{ __('Free Membership') }}</label>
                        </div>
                        <div class="flex items-center mb-4">
                            <input type="radio"
                                class="w-4 h-4 text-gray-900 dark:text-blue-600 bg-gray-100 border-gray-300 focus:ring-gray-300 dark:focus:ring-blue-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                name="members_account_type" value="2" onclick="showMembersAccount(2);"
                                @if(($errval['members_account_type'] ?? null)==2)checked @endif>
                            <label for="default-radio-2"
                                class="ms-2 text-xs text-gray-600 dark:text-gray-300">{{ __('Paid Membership') }}</label>
                        </div>

                        <div class="flex items-center mb-4">
                            <input type="radio"
                                class="w-4 h-4 text-gray-900 dark:text-blue-600 bg-gray-100 border-gray-300 focus:ring-gray-300 dark:focus:ring-blue-300 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                name="members_account_type" value="3" onclick="showMembersAccount(3);"
                                @if(($errval['members_account_type'] ?? null)==3)checked @endif>
                            <label for="default-radio-2"
                                class="ms-2 text-xs text-gray-600 dark:text-gray-300">{{ __('Free Entry') }}
                                &amp;{{ __('Upgrade') }}</label>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
        @include('matrixconfig.components.freemembership')
        @include('matrixconfig.components.paidmembership')
        @include('matrixconfig.components.freeentryupgrade')
        <!-- Subscription One-Time Fee Form Fields (toggle switch) -->


    </div>

    <div class="flex justify-between pt-6">
        <div class="form-submit">
            <button type="button" onclick="navigateTab('entry-criteria','plan-scaling','previous')"
                class="text-gray-900 bg-white border border-gray-300hover:bg-gray-100 rounded-lg text-xs px-4 py-2 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">{{ __('Back') }}</button>
        </div>
        <div class="form-submit">
            <button type="button" onclick="navigateTab('entry-criteria','commission-setting')"
                class="px-4 py-2 bg-gray-800 text-xs text-white hover:bg-gray-900 rounded-lg dark:bg-blue-500 dark:hover:bg-blue-600">{{ __('Continue') }}</button>
        </div>
    </div>
</div>
