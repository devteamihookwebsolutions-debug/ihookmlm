<div class="mb-5 {{ ($errval['members_account_type'] ?? null) == '2' ? '' : 'hidden' }}" id="show_paidmembership">
    <table class="min-w-2xl">
        <tbody>
            <tr id="show_paidmembership_fee_type"
                class="{{ ($errval['members_account_type'] ?? null) == '2' ? '' : 'hidden' }}">
                <td class="pe-6 text-gray-600 dark:text-gray-300 text-xs font-medium w-48">
                    {{ __('One Time Registration / Subscription') }}

                </td>
                <td class="px-6 text-right">
                    <div class="flex items-center p-2.5">
                        <!-- Left label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ __('One time fee') }}</span>

                        <!-- Toggle switch -->
                        <label class="inline-flex items-center cursor-pointer mx-3">
                            <input type="checkbox" id="members_paid_account_type" name="members_paid_account_type"
                                value="1" class="sr-only peer" @if(($errval['members_paid_account_type'] ??
                                0)==1)checked @endif onchange="toggleRegistrationSubscription()">
                            <div
                                class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-900 dark:peer-checked:bg-blue-600">
                            </div>
                        </label>

                        <!-- Right label -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Subscription') }}</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Subscription Form Fields -->


    <!-- One-Time Fee Form Fields -->


    @include('matrixconfig.components.onetimeregistration')

    @include('matrixconfig.components.subscription')


</div>
