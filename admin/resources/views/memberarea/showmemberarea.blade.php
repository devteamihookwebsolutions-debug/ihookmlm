@extends('admin::components.common.main')
@section('content')
<!-- Breadcrumb -->
<div class="">
    <div class="flex justify-between items-center flex-wrap">
        <div class="me-5 mb-5 lg:mb-0">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="/admin/dashboard"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                            <div class="relative w-5 h-5 flex items-center justify-center">

                                <!-- Animated Border ONLY -->
                                <span class="absolute inset-0 rounded-full border-2 border-yellow-600 dark:border-yellow-500
                                                animate-ping opacity-60"></span>

                                <!-- Static Icon -->
                                <svg class="w-3 h-3 text-gray-600 dark:text-gray-300 relative z-10" aria-hidden="true"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                            </div>
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ml-1 text-xs font-medium text-gray-500 hover:text-blue-600  dark:text-gray-400 dark:hover:text-white">{{ __('Distributors') }}</span>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="rtl:rotate-180 w-2 h-2 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg>
                            <span
                                class="ml-1 text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Member details') }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<main class="flex-grow">
    <div class="">
        <!--Success and Failure Messge-->
        @include('components.common.info_message')
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- share icon -->
        <div class="flex justify-end mb-5">
            <button id="dropdownDefaultButton" data-dropdown-toggle="sharedropdown"
                class="p-2 bg-yellow-500 rounded-full" type="button">
                <svg class="w-6 h-6 text-white" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                        d="M7.926 10.898 15 7.727m-7.074 5.39L15 16.29M8 12a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm12 5.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Zm0-11a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                </svg>
            </button>
            <div id="sharedropdown"
                class="z-10 overflow-hidden hidden bg-white text-xs text-gray-600 border border-gray-300 dark:border-gray-600 rounded-lg shadow w-40 dark:bg-gray-800 dark:border-gray-700">
                <ul class=" text-xs divide-y divide-gray-100 text-gray-600 dark:text-gray-300 dark:divide-gray-700"
                    aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="/admin/site-settings"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Site</a>
                    </li>
                    <li>
                        <a href="#"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Api
                            Configuration</a>
                    </li>
                </ul>
            </div>
        </div>
        <!--Success and Failure Messge-->
        <div class="bg-gray-800 text-white shadow-xl" role="alert">
            <div>
                <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between md:gap-0 gap-10">
                    <div class="flex items-center gap-5">
                        <div class="bg-white text-gray-900 font-bold text-sm px-5 py-2 rounded-lg shadow-lg">
                            <span class="">S</span>
                        </div>
                        <span class="md:text-md font-bold text-xs">{{ $errval['members_firstname'] }}
                            {{ $errval['members_lastname'] }} ({{ $errval['members_username'] }})<br><span
                                class="text-xs font-normal">{!! $members_email !!}</span></span>
                    </div>
                    <div class="flex gap-8">
                        <div class="bg-gray-700 border border-gray-600 px-6 py-3 rounded-lg text-center space-y-2">
                            <p class="text-gray-300 text-xs">C-Wallet</p>
                            <h2 class="font-medium text-xs" id="c-wallet-amount">
                                {{ $currency }}{{ $cWallet }}
                            </h2>
                        </div>
                        <div class="bg-gray-700 border border-gray-600 px-6 py-3 rounded-lg text-center space-y-2">
                            <p class="text-gray-300 text-xs">E-Wallet</p>
                            <h2 class="font-medium text-xs" id="e-wallet-amount">
                                {{ $currency }}{{ $eWallet }}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Row-1-->
        <!-- taps -->
        <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 mt-5">

            <!-- Tabs -->
            <div class="">
                <ul class="flex flex-wrap text-xs" id="distributor-tabs" data-tabs-toggle="#distributor-tab-content"
                    role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 border-blue-600 text-blue-600 active" id="summary-tab"
                            data-tabs-target="#summary" type="button" role="tab" aria-controls="summary"
                            aria-selected="true">{{ __('Summary') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="profile-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">{{ __('Profile') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="billing-tab"
                            data-tabs-target="#billing" type="button" role="tab" aria-controls="billing"
                            aria-selected="false">{{ __('Billing') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" onclick="personalpurchase();"
                            id="orders-tab" data-tabs-target="#orders" type="button" role="tab" aria-controls="orders"
                            aria-selected="false">{{ __('Orders') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="transaction-tab"
                            data-tabs-target="#transaction" type="button" role="tab" onclick="transaction();"
                            aria-controls="transaction" aria-selected="false">{{ __('Transaction') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="invoice-tab" onclick="invoice();"
                            data-tabs-target="#invoice" type="button" role="tab" aria-controls="invoice"
                            aria-selected="false">{{ __('Invoice') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="parties-tab"
                            onclick="showparties();" data-tabs-target="#parties" type="button" role="tab"
                            aria-controls="parties" aria-selected="false">{{ __('Parties') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="organization-tab"
                            data-tabs-target="#organization" type="button" role="tab" onclick="getGenealogyDetails();"
                            aria-controls="organization" aria-selected="false">{{ __('Organization') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="website-tab"
                            data-tabs-target="#website" type="button" role="tab" aria-controls="website"
                            aria-selected="false">{{ __('Website') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="compensation-tab"
                            data-tabs-target="#compensation" type="button" role="tab" onclick="getUserCommission()"
                            aria-controls="compensation" aria-selected="false">{{ __('Compensation') }}</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="wallet-tab"
                            onclick="getUserDeatilsWithdrawal();" data-tabs-target="#wallet" type="button" role="tab"
                            aria-controls="wallet" aria-selected="false">{{ __('Wallet') }}</button>
                    </li>
                    <li role="presentation">
                        <button class="block px-4 py-4 border-b-2 rounded-t-lg" id="note-tab"
                            onclick="getUserDeatilsMessage();" data-tabs-target="#note" type="button" role="tab"
                            aria-controls="note" aria-selected="false">{{ __('Note/Remarks') }}</button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-5 md:flex gap-5">
            <!-- Profile Card -->
            @include('memberarea.components._include_left_profile_section')
            <!-- Profile Card End -->
            <!-- Tables -->
            <main class="flex-1">
                <!-- Tab Content -->
                <div id="distributor-tab-content">
                    <!-- Summary -->
                    @include('memberarea.components._include_membersarea_summary')
                    <!-- Profile -->
                    @include('memberarea.components._include_membersarea_profile')
                    <!-- Billing -->
                    @include('memberarea.components._include_membersarea_billing_account')
                    <!-- Orders -->
                    @include('memberarea.components._include_membersarea_orders')
                    <!-- Transaction -->
                    @include('memberarea.components._include_membersarea_transaction')
                    <!-- Invoice -->
                    @include('memberarea.components._include_membersarea_invoice')
                    <!-- Parties -->
                    @include('memberarea.components._include_membersarea_parties')
                    <!-- Organization -->
                    @include('memberarea.components._include_membersarea_organization')
                    <!-- Website -->
                    @include('memberarea.components._include_membersarea_website')
                    <!-- Compensation -->
                    @include('memberarea.components._include_membersarea_compensation')
                    <!-- Wallet -->
                    @include('memberarea.components._include_membersarea_wallet')
                    <!-- Note -->
                    @include('memberarea.components._include_membersarea_remarksnote')
                </div>
            </main>
        </div>
        <!-- card -->
        <!--Row-1-->
    </div>
</main>

@include('memberarea.components.memberdetail_script')
<script>
if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !==
    'undefined') {
    const dataTable = new simpleDatatables.DataTable("#search-table", {
        searchable: true,
        sortable: false
    });
}

if (document.getElementById("notes-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#notes-table", {
        searchable: true,
        sortable: false
    });
}
</script>
@endsection
