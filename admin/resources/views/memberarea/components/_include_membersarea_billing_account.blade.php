<!-- File: admin/resources/views/memberarea/components/_include_membersarea_billing_account.blade.php -->

<div class="hidden" id="billing" role="tabpanel"
    aria-labelledby="billing-tab">
    <h2 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Billing') }}</h2>
    <div class=" bg-white dark:bg-gray-900 rounded-xl border dark:border-gray-800 p-5">
        <div class="mb-4 border-b border-neutral-200 dark:border-neutral-700">
            <ul class="flex flex-wrap -mb-px text-xs font-medium text-center" id="billing-tabs"
                data-tabs-toggle="#billing-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        id="account-info-tab" data-tabs-target="#account-info" type="button" role="tab"
                        aria-controls="account-info" aria-selected="true">
                        {{ __('Billing Account') }}
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button onclick="paymenthistory();"
                        class="inline-block p-4 border-b-2 rounded-t-lg text-black hover:text-black dark:text-white border-transparent hover:border-neutral-300 dark:border-transparent dark:hover:border-neutral-600"
                        id="payment-info-tab" data-tabs-target="#payment-info" type="button" role="tab"
                        aria-controls="payment-info" aria-selected="false">
                        {{ __('Payment History') }}
                    </button>
                </li>
            </ul>
        </div>

        <div id="billing-tab-content">
            <!-- Billing Account Tab -->
            <div id="account-info" role="tabpanel" aria-labelledby="account-info-tab">
                <div class="overflow-x-auto ">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-5">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Address') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Address Two') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('City') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('State') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Country') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Zip code') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white  dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $members_address }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $members_address2 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $members_city }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $members_state }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $country }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $members_zip }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment History Tab -->
            <div id="payment-info" role="tabpanel" aria-labelledby="payment-info-tab">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 mt-5">
                        <thead class="bg-gray-50 dark:bg-gray-800 ">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('S.No') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Date') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Description') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Payment Method') }}</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    {{ __('Amount') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 ">
                            @forelse($paymentHistory as $row)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $row->paymenthistory_date->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-4 py-2 text-xs text-gray-600 dark:text-gray-300">
                                    {{ $row->type_label }}
                                    @if($row->identify_type)
                                    <br><small
                                        class="text-gray-500 dark:text-gray-400">{{ $row->identify_type }}</small>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-xs text-gray-600 dark:text-gray-300">
                                    {{ $row->mode_label }}
                                </td>
                                <td class="px-4 py-2 text-xs  text-gray-600 dark:text-gray-300">
                                    {{ number_format($row->paymenthistory_amount, 2) }} {{ $row->currency_id ?? '' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('No payment history found.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>