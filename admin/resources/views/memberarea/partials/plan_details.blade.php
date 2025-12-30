<div class="xl:col-span-9 grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="bg-white rounded-lg shadow p-6 dark:bg-gray-800 border dark:border-gray-700 col-span-2">

        <!-- Genealogy Dropdown -->
        <div class="mt-4 flex items-center justify-start gap-4 relative">
            <div class="relative">
                <button id="genealogyDefaultButton" onclick="getGenealogydrown();"
                    class="inline-flex text-white items-center bg-gray-900 border border-gray-300 focus:outline-none hover:bg-gray-900 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-900 dark:text-white"
                    type="button">
                    Genealogy tree
                    <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"></path>
                    </svg>
                </button>

                <div id="genealogydropdown"
                    class="absolute left-0 mt-2 z-50 bg-white divide-y divide-gray-100 rounded-lg shadow w-56 dark:bg-gray-700 hidden">
                    <ul class="py-2 text-xs text-gray-600 dark:text-gray-300">
                        <li><a href="/admin/genealogy/viewtree/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Genealogy Tree</a></li>
                        <li><a href="/admin/genealogy/tabularview/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Tabular Genealogy</a></li>
                        <li><a href="/admin/grpgenealogy/viewtree/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Graphical Genealogy</a></li>
                        <li><a href="/admin/countgenealogy/viewtree/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Downline Count Genealogy</a></li>
                        <li><a href="/admin/rankgenealogy/viewtree/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Rank Genealogy</a></li>
                        <li><a href="/admin/collapsegenealogy/viewtree/{{ $member->members_id }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Collapse Genealogy</a></li>
                    </ul>
                </div>
            </div>

            <button type="button" onclick="showMatrixMoreInformation({{ $matrix_id }});"
                class="text-white brand-color font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:hover:bg-[#FF5D19]">
                More Info
            </button>
        </div>

        <!-- Referral Link -->
        <div class="mt-6 flex items-center justify-start gap-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">Referral Link :</p>
            <a href="{{ $referralLink }}" target="_blank" rel="noopener" class="text-sm text-blue-500">
                {{ $referralLink }}
            </a>
        </div>

        <!-- Table -->
        <table class="table table-hover table-striped table-bordered user_tab w-full mt-4">
            <tbody class="text-xs">
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Plan Type</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $planType }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Membership Type</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $membershipType }}</td>
                </tr>
                         <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Membership Status</td>
                   <td class="px-6 py-4 dark:text-gray-300" id="membership-status-{{ $member->members_id }}">

    @php
        $latestPayment = $packages->first();
        $status = $latestPayment?->paymenthistory_status;
    @endphp

    @if($latestPayment && in_array($status, ['notpaid', 'pending']))
        <button
            type="button"
            onclick="approvePayment({{ $member->members_id }}, {{ $matrix_id }}, {{ $latestPayment->paymenthistory_id }})"
            class="pending-approval-btn bg-red-100 text-red-800 text-xs font-medium px-3 py-1 rounded border border-red-400 hover:bg-red-200 transition"
            id="pending-btn-{{ $latestPayment->paymenthistory_id }}">
            <span class="flex items-center gap-2">
                <span class="loading hidden">Approving...</span>
                <span class="text w-28">Awaiting for admin approval</span>
            </span>
        </button>

    @elseif($latestPayment && $status === 'paid')
        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">
            Paid
        </span>
    @else
        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
            No Payment
        </span>
    @endif
</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Members Account login status</td>
                    <td class="px-6 py-4 dark:text-gray-300">
                        <a href="javascript:void(0);" onclick="changeMembersPlanStatus({{ $member->members_id }}, {{ $accountStatus === 'Active' ? 2 : 1 }}, 0);">
                            <span class="{{ $accountStatusClass }} text-xs font-medium me-2 px-2.5 py-0.5 rounded">
                                {{ $accountStatus }}
                            </span>
                        </a>
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Package</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $currentPackage }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Subscription Expiry Date</td>
                    <td class="px-6 py-4  text-gray-800 dark:text-gray-300">{{ $subscriptionExpiry }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Sponsor</td>
                    <td class="px-6 py-4  text-gray-800 dark:text-gray-300">
                        @if($sponsor)
                            <a href="{{ route('distributors.show', $sponsor->members_id) }}" class="text-blue-600 hover:underline">
                                {{ $sponsor->members_username }}
                            </a>
                        @else
                            {{ $get('default_sponsor_name', '—') }}
                        @endif
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Enroller</td>
                    <td class="px-6 py-4  text-gray-800 dark:text-gray-300">{{ $enroller }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Direct Referrals</td>
                    <td class="px-6 py-4 dark:text-gray-300">
                        <a href="#" class="text-blue-600 hover:underline">{{ $directReferrals }}</a>
                    </td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Date of Join</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $dateOfJoin }}</td>
                </tr>
                <tr class="border-b dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-600 dark:text-white">Current Rank</td>
                    <td class="px-6 py-4 text-gray-800 dark:text-gray-300">{{ $currentRank }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Payment Info Button -->
        <div class="flex flex-col mt-10">
            @if($packages->count())
                <button type="button"
                    onclick="viewPaymentDetails({{ $packages->first()->paymenthistory_id }}, {{ $member->members_id }})"
                    class="text-white inline-flex items-center justify-center bg-gray-900 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-900">
                    Payment Info
                </button>
            @endif
        </div>

        <!-- Payment Modal -->
        <div id="paymentmoreinformation-modal" tabindex="-1"
            class="hidden overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex"
            aria-modal="true" role="dialog">
            <div class="relative p-4 w-full max-w-xl max-h-full top-16">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Payment info</h3>
                        <button type="button" id="paymentmoreinformationcloseicon-modal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <div class="p-4 md:p-5 space-y-4">
                        <div id="view_payment_details">
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Payment Gateway :</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['gateway'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Transaction ID :</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['transaction_id'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Package</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['package_name'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Subscription Date :</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['subscription_date'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Subscription Expiry Date</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['expiry_date'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">Fee</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['fee'] ?? '—' }}" disabled>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-white">PaidCurrency</label>
                                <div class="col-lg-6 col-md-9 col-sm-12">
                                    <input type="text" class="bg-gray-50 border border-gray-300 text-gray-600 text-xs rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-gray-300 dark:focus:ring-gray-500 dark:focus:border-gray-500"
                                        value="{{ $paymentInfo['currency'] ?? '—' }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end py-6">
                        <button type="button" id="paymentmoreinformationclose-modal"
                            class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
