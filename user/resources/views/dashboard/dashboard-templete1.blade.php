@extends('user::components.common.main_templete1')
@section('content')
<main>
    @include('user::dashboard.components.frontline_popup')
    @include('user::dashboard.components.downline_popup')
    @include('user::dashboard.components.direct_downline_popup')
    @include('user::dashboard.components.packagepurchased_popup')
    @include('user::dashboard.components.orders_popup')
    @include('user::dashboard.components.totalcommissions_popup')
    @include('user::dashboard.components.pvstats_popup')
    @include('user::dashboard.components.gpvstats_popup')
    @include('user::dashboard.components.activememberstats_popup')
    @include('user::dashboard.components.paidaccountstats_popup')
    @include('user::dashboard.components.walletamount_popup')
    @include('user::dashboard.components.cwalletamount_popup')
    @include('user::dashboard.components.payoutdetails_popup')
    @include('user::dashboard.components.downlinesalesdetails_popup')
    @include('user::dashboard.components.dashboard_rankwizardpopup')
  <div class="relative">
            <div class="absolute inset-0 bg-cover bg-center h-96"
                style="background-image: url('/assets/img/user-dashboard/bg-6.jpg');">
                <div class="">
                    <!-- Welcome Message -->
                    <div class="text-center pt-32  text-white">
                        <h1
                            class="text-4xl font-bold">Welcome
                            back, Courtney Henry!</h1>
                        <p
                            class="text-lg mt-2">Let's
                            make it a productive day with
                            Global Trend.</p>
                    </div>
                </div>
      <!-- Main Content -->
        <div
            class="relative items-center justify-center pt-20 md:p-20 p-5">

         <!-- Row 1 -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-2">

    <!-- Left Card - User Info -->
    <div class="bg-white col-span-2 rounded-2xl p-6 shadow-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
        <div class="flex justify-between">
            <div class="flex items-center space-x-4">
                <img
                    src="{{ $block2details['membersimage'] ?? '/img/profile-picture-4.jpg' }}"
                    alt="User"
                    class="w-16 h-16 rounded-full ring-4 ring-amber-500">
                <div class="space-y-2">
                    <h2 class="font-semibold text-xs text-gray-800 dark:text-white">
                        {{ $member->members_firstname ?? 'Courtney' }} {{ $member->members_lastname ?? 'Henry' }}
                    </h2>

                     <p class="text-[8px] text-yellow-500">EXECUTIVE RANKS</p>

                        @php
                            $currentRank = collect($userRanks)->firstWhere('is_current', true);
                        @endphp

                        @if($currentRank)
                            <p class="text-gray-600 text-[10px] font-medium mt-1 mb-5 dark:text-gray-500">
                                {{ $currentRank['rank_title'] ?? 'No Rank Achieved' }}
                            </p>
                        @else
                            <p class="text-gray-600 text-[10px] font-medium mt-1 mb-5 dark:text-gray-500">
                                No Rank Achieved
                            </p>
                        @endif
                  <p class="flex px-2 py-1 rounded-lg border border-yellow-600 shadow-xl text-xs text-gray-600 dark:text-gray-300 items-center gap-1">
                        <span id="refLinkShort" class="truncate max-w-[180px]">
                            {{ config('app.url') }}/?ref={{ $member->members_username ?? 'dol' }}
                        </span>

                        <input type="hidden" id="fullRefLink"
                            value="{{ config('app.url') }}/?ref={{ $member->members_username ?? 'dol' }}">
                        <!-- Copy Button -->
                        <button id="copyRefBtn" title="Copy referral link"
                                class="p-1 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 rounded transition">

                               <svg class="w-5 h-5 text-yellow-700 dark:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z" />
                            </svg>
                        </button>

                        <!-- WhatsApp Share -->
                        <button id="shareWhatsapp" title="Share on WhatsApp"
                                class="p-1 hover:bg-green-100 dark:hover:bg-green-900/30 rounded transition">

                            <svg class="w-5 h-5 text-yellow-700 dark:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h4V4m12 4h-4V4M4 16h4v4m12-4h-4v4" />
                            </svg>
                        </button>

                        <!-- Facebook / General Share (you can change icon if needed) -->
                        <button id="shareGeneral" title="Share link"
                                class="p-1 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded transition">
   <svg class="w-5 h-5 text-yellow-700 dark:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15.141 6 5.518 4.95a1.05 1.05 0 0 1 0 1.549l-5.612 5.088m-6.154-3.214v1.615a.95.95 0 0 0 1.525.845l5.108-4.251a1.1 1.1 0 0 0 0-1.646l-5.108-4.251a.95.95 0 0 0-1.525.846v1.7c-3.312 0-6 2.979-6 6.654v1.329a.7.7 0 0 0 1.344.353 5.174 5.174 0 0 1 4.652-3.191l.004-.003Z" />
                            </svg>
                        </button>
                    </p>
                </div>
            </div>

            <div>
                <label class="inline-flex items-center cursor-pointer">
                    <span class="text-xs text-gray-600 dark:text-gray-300">Auto package upgrade</span>
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="ms-3 relative w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                </label>
            </div>
        </div>

        <!-- sales section -->
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Total Commission -->
            <div class="p-3 bg-white w-full border border-gray-200 shadow-xl rounded-2xl items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 ">
                <div class="ring-2 ring-yellow-700 dark:ring-yellow-500 rounded-full p-1 w-10">
                    <svg class="w-8 h-8 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z" />
                    </svg>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Total commission</h3>
                        <a href class="text-gray-500">
                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $currency ?? '$' }}{{ number_format($totalcommission ?? 0, 2) }}
                            </span>
                        </a>
                    </div>
                    <div class="w-20 h-16">
                        <canvas id="totalcommission"></canvas>
                    </div>
                </div>
            </div>

            <!-- Package Purchased -->
            <div class="p-3 bg-white w-full border border-gray-200 shadow-xl rounded-2xl items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 ">
                <div class="ring-2 ring-yellow-700 dark:ring-yellow-500 rounded-full p-1 w-10">
                    <svg class="w-8 h-8 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z" />
                    </svg>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Package Purchased</h3>
                        <a href class="text-gray-500">
                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $currency ?? '$' }}{{ number_format($packagePurchased ?? 0, 2) }}
                            </span>
                        </a>
                    </div>
                    <div class="w-20 h-16">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- New Enrollment -->
            <div class="p-3 bg-white w-full border border-gray-200 shadow-xl rounded-2xl items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 ">
                <div class="ring-2 ring-yellow-700 dark:ring-yellow-500 rounded-full p-1 w-10">
                    <svg class="w-8 h-8 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-800 dark:text-gray-300">New Enrollment</h3>
                        <a href>
                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ $todayEnrollments ?? '0' }}</span>
                        </a>
                    </div>
                    <div class="w-20 h-16">
                        <canvas id="newenrollmentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- small sales section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 mt-5 gap-2">
            <div class="bg-white overflow-hidden border shadow-xl border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                <div class="items-center justify-between flex">
                    <div class="space-y-2">
                        <h2 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Total Downlines</h2>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $totalDownlines ?? '0' }}</p>
                        <p class="text-xs text-gray-500 font-normal">
                            <span class="{{ ($downlineChange ?? 0) >= 0 ? 'text-blue-500' : 'text-red-500' }}">
                                {{ abs($downlineChange ?? 0) }}%
                            </span> since last month
                        </p>
                    </div>
                    <div class="rounded-full p-1 ring-2 ring-yellow-700 dark:ring-yellow-500">
                        <svg class="w-10 h-10 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border shadow-xl border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                <div class="items-center justify-between flex">
                    <div class="space-y-2">
                        <h2 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Personal Details</h2>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ $currency ?? '$' }}{{ number_format($personalPV ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-gray-500 font-normal">
                            <span class="{{ ($personalChange ?? 0) >= 0 ? 'text-blue-500' : 'text-red-500' }}">
                                {{ abs($personalChange ?? 0) }}%
                            </span> since last month
                        </p>
                    </div>
                    <div class="rounded-full p-1 ring-2 ring-yellow-700 dark:ring-yellow-500">
                        <svg class="w-10 h-10 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border shadow-xl border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                <div class="items-center justify-between flex">
                    <div class="space-y-2">
                        <h2 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Personal Sales: </h2>
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            {{ $currency ?? '$' }}{{ number_format($totalcommission ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-blue-500">
                            {{ $currency ?? '$' }}{{ number_format($downlineSales ?? 0, 2) }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Downline sales</p>
                    </div>
                    <div class="rounded-full p-1 ring-2 ring-yellow-700 dark:ring-yellow-500">
                        <svg class="w-10 h-10 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden border shadow-lg border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                <h2 class="text-xs font-semibold text-gray-800 dark:text-gray-300">Group Downline</h2>
                <div class="flex items-center justify-between mt-5">
                    <div class="flex items-center gap-10">
                        <div>
                            <h2 class="text-xs font-medium text-gray-800 dark:text-gray-300">Total Downlines: </h2>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">{{ $totalGroupDownlines ?? '0' }}</p>
                        </div>
                        <div>
                            <h2 class="text-xs font-medium text-gray-800 dark:text-gray-300">Paid Members: </h2>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">{{ $paidMembersInGroup ?? '0' }}</p>
                        </div>
                    </div>
                    <div class="rounded-full p-1 ring-2 ring-yellow-700 dark:ring-yellow-500">
                        <svg class="w-10 h-10 text-yellow-700 dark:text-yellow-500" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Card - Sponsor Info -->
    <div class="space-y-2">

        <!-- Sponsor Card -->
        <div class="bg-white rounded-2xl p-6 h-fit shadow-xl dark:bg-gray-900 border border-gray-200 dark:border-gray-800">
            <div>
                <div class="flex space-x-4 items-center">
                    <img
                        src="{{ $block2details['sponsorimage'] ?? '/img/av-ico-1.png' }}"
                        alt="Sponsor"
                        class="w-16 h-16 rounded-full ring-4 ring-amber-500">
                    <div class="space-y-1 ml-5">
                        <h2 class="text-xs text-gray-500 dark:text-gray-400">Your Sponsor</h2>
                        <p class="text-xs font-semibold text-gray-800 dark:text-white">
                            {{ $block2details['sponsor_fullname'] ?? 'Bessie Cooper' }}
                        </p>
                        <p class="text-xs text-blue-500 underline">
                            {{ $member->members_email ?? 'Example@gmail.com' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <ul class="text-xs divide-y divide-gray-200 dark:divide-gray-700">
                        <li class="flex justify-between p-2">
                            <span class="text-gray-500 dark:text-gray-400">Login :</span>
                            <span class="text-gray-800 font-medium dark:text-gray-200">
                                {{ $member->members_username ?? 'Courtney Henry' }}
                            </span>
                        </li>
                        <li class="flex justify-between p-2">
                            <span class="text-gray-500 dark:text-gray-400">Package :</span>
                            <span class="text-gray-800 font-medium dark:text-gray-200">
                                {{ $block2details['package_name'] ?? 'Paquete 300' }}
                            </span>
                        </li>
                        <li class="flex justify-between p-2">
                            <span class="text-gray-500 dark:text-gray-400">Date Of Joined :</span>
                            <span class="text-gray-800 font-medium dark:text-gray-200">
                                {{ $member->members_doj ? \Carbon\Carbon::parse($member->members_doj)->format('d/m/Y') : '11/02/2025' }}
                            </span>
                        </li>
                        <li class="flex justify-between p-2">
                            <span class="text-gray-500 dark:text-gray-400">Qualification :</span>
                            <span class="text-gray-800 font-medium dark:text-gray-200">
                                @forelse($userRanks as $rank)
                                    @if($rank['progress'] == '100%' || $rank['progress'] == '100')
                                        {{ $rank['rank_title'] }}
                                        @break
                                    @endif
                                @empty
                                    No Rank Achieved
                                @endforelse
                            </span>
                        </li>
                    </ul>
                </div>

                <div class="flex items-center justify-center mt-5">
                    <button class="text-xs text-white rounded-full px-4 py-2 bg-yellow-700 hover:bg-yellow-800 dark:bg-yellow-600 dark:hover:bg-yellow-500">
                        Upgrade Package
                    </button>
                </div>
            </div>
        </div>

<!-- My wallet -->
<div style="background-image: url('/assets/img/user-dashboard/wal-bg-1.jfif');"
     class="bg-center bg-cover shadow-xl rounded-2xl text-white p-5">

    <div class="flex justify-between items-start">
        <div class="flex items-center gap-2">
            <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z" clip-rule="evenodd" />
                <path fill-rule="evenodd" d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z" clip-rule="evenodd" />
            </svg>
            <h2 class="text-xs uppercase font-medium">Main Account</h2>
        </div>

        <svg class="w-6 h-6 text-white opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
    </div>

    <h2 class="text-2xl font-semibold mt-5">
        {{ $currency ?? '$' }}{{ number_format($totalWallet ?? 0, 2) }}
        <span class="text-[10px] text-gray-800"> / Your Wallet Amount</span>
    </h2>

    <div id="wallet-detail" class="mt-3 text-xs transition-all duration-300">
        <p class="text-gray-800">
            <span id="detail-label">Awaiting Withdrawal :</span>
            <span class="text-white font-bold" id="detail-value">
                {{ $currency ?? '$' }}{{ number_format(($totalcommission ?? 0) - ($withdrawal ?? 0), 2) }}
            </span>
        </p>
    </div>

    <div class="mt-7 mb-3">
        <a class="flex items-center justify-center gap-8 w-fit text-xs px-4 py-1 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl shadow-lg">
            <button onclick="showDetail('withdrawal')" class="border-r pr-8 hover:text-white/80 transition">
                Withdrawal
            </button>
            <button onclick="showDetail('transfer')" class="hover:text-white/80 transition">
                Transfer
            </button>
        </a>
    </div>
</div>



    </div>
</div>
          <!-- Member Stats Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mt-8">

                <!-- small sales (ApexCharts placeholders - kept as is) -->
                <div id="column-chart"></div>
                <!-- <div id="radial-chart"></div> -->
                <div id="pie-chart"></div>

                <!-- Member Stats -->
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-xl dark:border-gray-800 dark:bg-gray-900 h-fit w-full">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-white mb-3">
                        Member Stats
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-3 mb-5">

                        <!-- PV Card (Purchase Volume) -->
                        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:shadow-md transition flex justify-between items-center"
                            onclick="showBlockModal('pvStatsModal','pvStatsTable','getpvstats')">
                            <div class="widget-data mb-3">
                                <h3 class="text-xs text-gray-600 dark:text-blue-500 mb-2">Purchase volume</h3>
                                <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    <span class="text-sm dark:text-gray-500" id="pv-value">0</span>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <svg class="w-5 h-5 text-yellow-500" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- GPV Card (Gross Purchase Volume) -->
                        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:shadow-md transition flex justify-between items-center"
                            onclick="showBlockModal('gpvStatsModal','gpvStatsTable','getgpvstats')">
                            <div class="mb-3">
                                <h3 class="text-xs text-gray-600 dark:text-blue-500 mb-2">Gross purchase volume</h3>
                                <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    <span class="text-sm dark:text-gray-500" id="gpv-value">0</span>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <svg class="w-5 h-5 text-red-900 dark:text-red-900" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z"/>
                                    <path d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Active Members Card -->
                        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:shadow-md transition flex justify-between items-center"
                            onclick="showBlockModal('activeMemberStatsModal','activeMemberStatsTable','getactivememberstats')">
                            <div class="widget-data mb-3">
                                <h3 class="text-xs text-gray-600 dark:text-blue-500 mb-2">Active Members</h3>
                                <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    <span class="text-sm dark:text-gray-500" id="active-members">0</span>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-500" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Paid Accounts Card -->
                        <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-900 cursor-pointer hover:shadow-md transition flex justify-between items-center"
                            onclick="showBlockModal('paidAccountStatsModal','paidAccountStatsTable','getpaidaccountstats')">
                            <div class="widget-data mb-3">
                                <h3 class="text-xs text-gray-600 dark:text-blue-500 mb-2">Paid Accounts</h3>
                                <div class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                                    <span class="text-sm dark:text-gray-500" id="paid-members">0</span>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <svg class="w-5 h-5 text-blue-400 dark:text-blue-400" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 7V2.221a2 2 0 00-.5.365L4.586 6.5a2 2 0 00-.365.5H9Z"/>
                                    <path fill-rule="evenodd" d="M11 7V2h7a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V9h5a2 2 0 002-2zm4.707 5.707a1 1 0 00-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center justify-center">
                        <button type="button"
                                class="text-white bg-yellow-700 hover:bg-yellow-800 font-medium rounded-full text-xs px-4 py-2 text-center dark:bg-yellow-600 dark:hover:bg-yellow-500">
                            View More
                        </button>
                    </div>
                </div>

            </div>

            <!-- Row 3 -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mt-8">


            <!-- order chart -->
            <div class="bg-white p-5 border border-gray-200 rounded-lg shadow-xl col-span-2 dark:bg-gray-900 dark:border-gray-800">
                <div class="max-w-4xl mx-auto">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h2 class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                    Delivery Statistics
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Total number of Orders <span id="total-orders">0</span>
                                </p>
                            </div>

                            <!-- Dropdown (kept exactly as you had - can be made functional later if needed) -->
                            <button id="dropdownDefaultButton"
                                    data-dropdown-toggle="dropdown"
                                    class="text-xs px-4 py-2 border rounded-lg bg-gray-50 dark:bg-gray-800
                                        text-gray-700 dark:text-gray-300 dark:border-gray-700">
                                Monthly
                            </button>

                            <div id="dropdown"
                                class="hidden z-10 w-32 bg-white divide-y divide-gray-100 rounded-lg shadow
                                    dark:bg-gray-800">
                                <ul class="py-2 text-xs text-gray-700 dark:text-gray-200 overflow-hidden">
                                    <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="#">Monthly</a></li>
                                    <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="#">Weekly</a></li>
                                    <li><a class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600" href="#">Yearly</a></li>
                                </ul>
                            </div>
                        </div>

                        <canvas id="deliveryChart" height="140"></canvas>
                    </div>
                </div>
            </div>


         <!-- Rank progress -->
            <div class="rounded-2xl h-fit border border-gray-200 shadow-xl bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="items-center justify-center p-3">
                    <div class="bg-white dark:border-gray-800 dark:bg-gray-900">
                        <div class="mt-4 justify-center mb-4">
                            <h2 class="text-center text-sm font-medium text-gray-800 dark:text-white">
                                My Rank
                            </h2>
                        </div>

                        <!-- Tabs -->
                        <div class="flex justify-center gap-3 mb-4 text-xs mt-10">
                            <button class="tab-btn px-2 py-1 rounded-2xl bg-yellow-700 text-white dark:bg-yellow-600" data-tab="current">
                                Current Rank
                            </button>
                            <button class="tab-btn px-2 py-1 rounded-2xl bg-gray-300 text-gray-700" data-tab="last">
                                Last Rank
                            </button>
                            <button class="tab-btn px-2 py-1 rounded-2xl bg-gray-300 text-gray-700" data-tab="history">
                                Rank History
                            </button>
                        </div>

                        <!-- Tab Contents -->
                        <div class="tab-contents relative mt-8">

                            <!-- Current Rank Widget (Slider) -->
                            <div class="tab-content" data-content="current">
                                <div class="relative overflow-hidden h-72 text-center">
                                    <div id="rank-cards" class="flex transition-transform duration-500">
                                        @forelse($userRanks as $rank)
                                            <div class="min-w-full flex flex-col justify-center items-center bg-white dark:bg-gray-900 p-4">
                                                <svg width="150" height="80" viewBox="0 0 200 100">
                                                    <path d="M10,100 A90,90 0 0,1 190,100" stroke="#E5E7EB" stroke-width="11" fill="none" />
                                                    <path class="progress-arc"
                                                        d="M10,100 A90,90 0 0,1 190,100"
                                                        stroke="{{ $rank['rank_color'] ?? '#E3A008' }}"
                                                        stroke-width="12" fill="none"
                                                        stroke-dasharray="283"
                                                        stroke-dashoffset="283"
                                                        stroke-linecap="round"
                                                        data-target="{{ $rank['progress'] ?? '0' }}" />
                                                </svg>
                                                <span class="progress-text text-xs font-normal mt-2" style="color: {{ $rank['rank_color'] ?? '#E3A008' }}">
                                                    0%
                                                </span>
                                                <h3 class="mt-4 text-xs font-normal text-gray-700 dark:text-gray-300">
                                                    {{ $rank['rank_title'] ?? 'No Rank' }}
                                                </h3>

                                                <div class="mt-10">
                                                    <button onclick="openRankModal({{ json_encode($rank['conditions'] ?? [], JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP) }}, '{{ addslashes($rank['rank_title'] ?? 'No Rank') }}')"
                                                            class="mx-auto text-xs px-3 py-1 bg-yellow-700 dark:bg-yellow-600 text-white rounded-2xl
                                                                transition-all duration-300 ease-out
                                                                shadow-md shadow-yellow-500/30
                                                                hover:shadow-yellow-500/80 hover:shadow-[0_0_25px] hover:-translate-y-1">
                                                        View Rank Requirement
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="min-w-full flex flex-col justify-center items-center bg-white dark:bg-gray-900 p-4">
                                                <p class="text-gray-500 text-xs">No ranks available yet</p>
                                            </div>
                                        @endforelse
                                    </div>

                                    <!-- Prev/Next Buttons -->
                                    <button id="prev-btn" class="absolute left-0 md:ml-0 ml-10 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-white" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button id="next-btn" class="absolute right-0 md:mr-0 mr-10 top-1/2 transform -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-white" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Last Rank Tab -->
                            <div class="tab-content hidden" data-content="last">
                                <div class="p-2 h-72 text-center text-gray-700 dark:text-gray-300">
                                    <div>
                                        <table class="w-full text-xs justify-between text-gray-500">
                                            <thead class="text-xs uppercase bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-500">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2">Rank</th>
                                                    <th scope="col" class="px-3 py-2">Date</th>
                                                    <th scope="col" class="px-3 py-2">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($previousRank as $rank)
                                                    <tr class="border-b dark:border-gray-700">
                                                        <td class="px-3 py-2 font-medium text-gray-800 dark:text-white">
                                                            {{ $rank['rank_title'] ?? '—' }}
                                                        </td>
                                                        <td class="px-3 py-2 text-gray-600 dark:text-gray-400">
                                                            {{ $member->members_doj ? \Carbon\Carbon::parse($member->members_doj)->format('d M Y') : 'N/A' }}
                                                        </td>
                                                        <td class="px-3 py-2">
                                                            <span class="text-green-600 font-medium text-xs">Achieved</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3">
                                                            <div class="flex flex-col items-center justify-center py-6 text-gray-400">
                                                                <svg class="w-12 h-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M9 12h6m2 8H7a2 2 0 01-2-2V6a2 2 0 012-2h8l6 6v10a2 2 0 01-2 2z" />
                                                                </svg>
                                                                <p class="text-xs">No previous rank achieved yet</p>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    @if(empty($previousRank))
                                        <div class="mt-4">
                                            <p class="text-gray-600 text-xs">You are on your first rank. Keep growing! 🚀</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Rank History Tab -->
                            <div class="tab-content hidden" data-content="history">
                                <div class="p-2 h-72 text-center text-gray-700 dark:text-gray-300">
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-xs text-left text-gray-500">
                                            <thead class="text-xs uppercase bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-500">
                                                <tr>
                                                    <th scope="col" class="px-3 py-2">Rank</th>
                                                    <th scope="col" class="px-3 py-2 text-right">Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($userRanks as $rank)
                                                    <tr class="border-b hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-700">
                                                        <td class="px-3 py-2 font-normal text-gray-700 dark:text-gray-300">
                                                            {{ $rank['rank_title'] ?? '—' }}
                                                        </td>
                                                        <td class="px-3 py-2 text-right">
                                                            <button class="p-1.5 border border-gray-300 rounded-full">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.945a1 1 0 00.95.69h4.146c.969 0 1.371 1.24.588 1.81l-3.357 2.44a1 1 0 00-.364 1.118l1.286 3.945c.3.921-.755 1.688-1.54 1.118l-3.357-2.44a1 1 0 00-1.176 0l-3.357 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.945a1 1 0 00-.363-1.118l-3.357-2.44c-.784-.57-.38-1.81.588-1.81h4.146a1 1 0 00.95-.69l1.286-3.945z" />
                                                                </svg>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="2" class="text-center py-6 text-gray-400 text-xs">
                                                            No rank history available
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
                </div>
            </div>

            <!-- Modal (same as your first dashboard) -->
            <div id="rankModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 h-96 overflow-y-auto">
                    <h3 id="modalTitle" class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4"></h3>
                    <div id="modalConditions"></div>
                    <button onclick="document.getElementById('rankModal').classList.add('hidden')"
                            class="mt-4 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-xs dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded">
                        Close
                    </button>
                </div>
            </div>
            </div>
             <!-- 3rd Row  -->
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-5 mt-8">
                <!-- 1st col -->
                <div
                    class="rounded-2xl border h-fit border-gray-200 bg-white p-7 dark:border-gray-800 dark:bg-gray-900">
                    <div class="  mb-5">
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white/90">
                            Sales Category
                        </h3>
                        <div class="relative mx-auto w-56 h-64 mt-10">
                            <canvas id="salesChart"></canvas>
                            <!-- Center text -->
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-gray-800 font-normal text-sm dark:text-gray-400">Total</span>
                                <span class="text-sm font-bold text-gray-800 dark:text-gray-400">2450</span>
                            </div>
                        </div>
                        <!-- Legend -->
                        <div class="flex flex-col gap-3 text-sm mt-7 ml-16 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
                                <div>
                                    <p class="text-gray-800 font-medium dark:text-gray-400">Affiliate Program
                                    </p>
                                    <p class="text-gray-500 text-xs">48% • 2,040 Products</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-400 rounded-full"></span>
                                <div>
                                    <p class="text-gray-800 font-medium dark:text-gray-400">Direct Buy</p>
                                    <p class="text-gray-500 text-xs">33% • 1,402 Products</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-200 rounded-full"></span>
                                <div>
                                    <p class="text-gray-800 font-medium dark:text-gray-400">Adsense</p>
                                    <p class="text-gray-500 text-xs">19% • 510 Products</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 2nd col -->
                <div>
                    <div
                        class="w-auto h-fit p-5 bg-white border border-gray-200 rounded-2xl relative overflow-hidden dark:bg-gray-900 dark:border-gray-800">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white">Trending Products
                            </h3>
                            <div class="flex gap-2">
                                <!-- Prev Button -->
                                <button id="prevBtn"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded-full dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 dark:text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <!-- Next Button -->
                                <button id="nextBtn"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 p-2 rounded-full dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 dark:text-gray-300" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Slider Container -->
                        <div class="relative w-full overflow-hidden">
                            <div id="cardSlider" class="flex transition-transform duration-500 ease-in-out">
                                <!-- Card 1 -->
                                <div
                                    class="min-w-full p-4 text-center border border-gray-200 rounded-xl bg-gray-100 dark:bg-gray-800 dark:border-gray-800">
                                    <div
                                        class="flex items-center justify-between pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10">
                                                <img src="/img/tr-product-01.png" alt="brand" />
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                    Apple
                                                </h3>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    Macbook, Inc
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h4
                                                    class="mb-1 font-medium text-right text-gray-700 text-xs dark:text-gray-400">
                                                    $192.53
                                                </h4>
                                            </div>
                                            <span
                                                class="flex items-center justify-end gap-1 font-medium text-xs text-success-600 dark:text-success-500">
                                                <svg class="fill-current" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill="" />
                                                </svg>
                                                1.01%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <button
                                            class=" w-auto text-center rounded-lg border border-gray-200 bg-white p-3 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:text-white">
                                            Short Products
                                        </button>
                                        <button
                                            class="text-xs text-center w-auto p-3 font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600 ">
                                            Buy Products
                                        </button>
                                    </div>
                                </div>

                                <!-- Card 2 -->
                                <div
                                    class="min-w-full p-4 text-center border border-gray-200 rounded-xl bg-gray-100 dark:bg-gray-800 dark:border-gray-800">
                                    <div
                                        class="flex items-center justify-between pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10">
                                                <img src="/img/tr-product-02.png" alt="brand" />
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                    Apple
                                                </h3>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    Smartwatch, Inc
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h4
                                                    class="mb-1 font-medium text-right text-gray-700 text-xs dark:text-gray-400">
                                                    $192.53
                                                </h4>
                                            </div>
                                            <span
                                                class="flex items-center justify-end gap-1 font-medium text-xs text-success-600 dark:text-success-500">
                                                <svg class="fill-current" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill="" />
                                                </svg>
                                                1.01%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <button
                                            class=" w-auto text-center rounded-lg border border-gray-300 bg-white p-3 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:text-white">
                                            Short Products
                                        </button>
                                        <button
                                            class="text-xs text-center w-auto p-3 font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600">
                                            Buy Products
                                        </button>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div
                                    class="min-w-full p-4 text-center border border-gray-200 rounded-xl bg-gray-100 dark:bg-gray-800 dark:border-gray-800">
                                    <div
                                        class="flex items-center justify-between pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10">
                                                <img src="/img/tr-product-03.png" alt="brand" />
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                    Apple
                                                </h3>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    IPhone, Inc
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h4
                                                    class="mb-1 font-medium text-right text-gray-700 text-xs dark:text-gray-400">
                                                    $192.53
                                                </h4>
                                            </div>
                                            <span
                                                class="flex items-center justify-end gap-1 font-medium text-xs text-success-600 dark:text-success-500">
                                                <svg class="fill-current" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill="" />
                                                </svg>
                                                1.01%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <button
                                            class=" w-auto text-center rounded-lg border border-gray-300 bg-white p-3 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:text-white">
                                            Short Products
                                        </button>
                                        <button
                                            class="text-xs text-center w-auto p-3 font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600">
                                            Buy Products
                                        </button>
                                    </div>
                                </div>

                                <!-- Card 3 -->
                                <div
                                    class="min-w-full p-4 text-center border border-gray-200 rounded-xl bg-gray-100 dark:bg-gray-800 dark:border-gray-800">
                                    <div
                                        class="flex items-center justify-between pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10">
                                                <img src="/img/tr-product-04.png" alt="brand" />
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                    Apple
                                                </h3>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    IPad, Inc
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h4
                                                    class="mb-1 font-medium text-right text-gray-700 text-xs dark:text-gray-400">
                                                    $192.53
                                                </h4>
                                            </div>
                                            <span
                                                class="flex items-center justify-end gap-1 font-medium text-xs text-success-600 dark:text-success-500">
                                                <svg class="fill-current" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill="" />
                                                </svg>
                                                1.01%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <button
                                            class=" w-auto text-center rounded-lg border border-gray-300 bg-white p-3 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:text-white">
                                            Short Products
                                        </button>
                                        <button
                                            class="text-xs text-center w-auto p-3 font-medium text-white rounded-lg bg-blue-500 hover:bg-blue-600">
                                            Buy Products
                                        </button>
                                    </div>
                                </div>

                                <!-- Card 5 -->
                                <div
                                    class="min-w-full p-4 text-center border border-gray-200 rounded-xl bg-gray-100 dark:bg-gray-800 dark:border-gray-800">
                                    <div
                                        class="flex items-center justify-between pb-5 mb-5 border-b border-gray-200 dark:border-gray-700">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10">
                                                <img src="/img/tr-product-05.png" alt="brand" />
                                            </div>
                                            <div>
                                                <h3
                                                    class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                                    Apple
                                                </h3>
                                                <span class="block text-gray-500 text-xs dark:text-gray-400">
                                                    Airpods, Inc
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>
                                                <h4
                                                    class="mb-1 font-medium text-right text-gray-700 text-xs dark:text-gray-400">
                                                    $192.53
                                                </h4>
                                            </div>
                                            <span
                                                class="flex items-center justify-end gap-1 font-medium text-xs text-success-600 dark:text-success-500">
                                                <svg class="fill-current" width="12" height="12"
                                                    viewBox="0 0 12 12" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M5.56462 1.62394C5.70193 1.47073 5.90135 1.37433 6.12329 1.37433C6.1236 1.37433 6.12391 1.37433 6.12422 1.37433C6.31631 1.37416 6.50845 1.44732 6.65505 1.59381L9.65514 4.59181C9.94814 4.8846 9.94831 5.35947 9.65552 5.65247C9.36273 5.94546 8.88785 5.94563 8.59486 5.65284L6.87329 3.93248L6.87329 10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125L5.37329 3.93579L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65249C2.3017 5.3595 2.30185 4.88463 2.59484 4.59183L5.56462 1.62394Z"
                                                        fill="" />
                                                </svg>
                                                1.01%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between gap-3">
                                        <button
                                            class=" w-auto text-center rounded-lg border border-gray-300 bg-white p-3 text-xs font-medium text-gray-700 hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:text-white">
                                            Short Products
                                        </button>
                                        <button
                                            class="text-xs text-center w-auto p-3 font-medium text-white rounded-lg bg-blue-500  hover:bg-blue-600">
                                            Buy Products
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <div
                            class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-900">
                            <div class="mb-6 flex justify-between">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white">
                                        Current Rate
                                    </h3>
                                    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                        Downgrade to Free plan
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-800 dark:text-white">
                                        4.26%
                                    </h3>
                                    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                        <span class="text-error-500 mr-1 inline-block">0.31%</span>
                                        than last Week
                                    </p>
                                </div>
                                <div class="max-w-full">
                                    <div id="chartTwentyOne" class="h-12 w-24"></div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="overflow-hidden rounded-2xl border mt-3 border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-900">
                            <div class="mb-6 flex justify-between">
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-800 dark:text-white/90">
                                        User Growth
                                    </h3>
                                    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                        New signups website + mobile
                                    </p>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-800 dark:text-white/90">
                                        3,768
                                    </h3>
                                    <p class="text-xs mt-1 text-gray-500 dark:text-gray-400">
                                        <span class="text-success-600 mr-1 inline-block">+3.85%</span>
                                        than last Week
                                    </p>
                                </div>
                                <div class="max-w-full">
                                    <div id="chartTwentyTwo" class="h-12 w-24"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 3rd col -->
                <div
                    class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                    <div class="mb-6 flex justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                                Activities
                            </h3>
                        </div>
                    </div>
                        <div class="relative space-y-8" id="activities-timeline">
                        <div class="absolute top-6 bottom-10 left-5 w-px bg-gray-200 dark:bg-gray-800">
                    </div>
                </div>
            </div>
        </div>
</main>

<script>
    const allDownlines = @json($allOrders->mapWithKeys(fn($items, $id) => [$id => $items]));
    const recentData   = @json($recentOrders->mapWithKeys(fn($items, $id) => [$id => $items]));

    function filterData(sourceObj) {
        const status   = $('#filterStatus' + (sourceObj === recentData ? 'Recent' : 'All')).val();
        const country  = $('#filterCountry' + (sourceObj === recentData ? 'Recent' : 'All')).val();

        return Object.fromEntries(
            Object.entries(sourceObj).filter(([_, items]) => {
                const m = items[0];
                const isPaid = (m.order_total ?? 0) > 0;
                const memberStatus = isPaid ? 'Paid' : 'Pending';

                const matchStatus  = !status  || memberStatus === status;
                const matchCountry = !country || m.members_country === country;

                return matchStatus && matchCountry;
            })
        );
    }

    function renderRecent() {
        const data = filterData(recentData);
        const html = Object.values(data).map(items => {
            const m = items[0];
            const isPaid = (m.order_total ?? 0) > 0;
            const status = isPaid ? 'Paid' : 'Pending';
            const statusClass = isPaid
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';

            return `
                <tr class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                    data-country="${m.members_country}" data-status="${status}">
                    <td class="px-6 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-md bg-gray-200 border-2 border-dashed border-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                <img src="https://flagcdn.com/24x18/${(m.members_country||'in').toLowerCase()}.png" class="rounded">
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 text-theme-sm dark:text-white/90">
                                    ${m.members_firstname} ${m.members_lastname}
                                </p>
                                <span class="text-gray-500 text-theme-xs dark:text-gray-400">
                                    ${m.members_username} • ${m.members_country}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-3"><p class="text-gray-500 text-theme-sm dark:text-gray-400">${m.package_name || 'Free'}</p></td>
                    <td class="px-6 py-3"><p class="text-gray-500 text-sm dark:text-gray-400">${Number(m.order_total||0).toLocaleString()}</p></td>
                    <td class="px-6 py-3">
                        <span class="text-xs font-medium me-2 px-2.5 py-0.5 rounded ${statusClass}">${status}</span>
                    </td>
                </tr>`;
        }).join('');

        $('#recentBody').html(html || '<tr><td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No members match</td></tr>');
    }

    let currentPage = 1;
    const perPage   = 10;
    let filteredAll = {...allDownlines};

    function renderAll() {
        const start = 0;
        const end   = currentPage * perPage;
        const data  = Object.values(filteredAll).slice(start, end);

        const html = data.map(items => {
            const m = items[0];
            const isPaid = (m.order_total ?? 0) > 0;
            const status = isPaid ? 'Paid' : 'Pending';
            const statusClass = isPaid
                ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
            const joined = m.created_on || m.members_doj;

            return `
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <img src="https://flagcdn.com/16x12/${(m.members_country||'in').toLowerCase()}.png" class="w-4 h-3">
                            <div>
                                <p class="font-medium text-sm">${m.members_firstname} ${m.members_lastname}</p>
                                <p class="text-xs text-gray-500">${m.members_username}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">${m.package_name || 'Free'}</td>
                    <td class="px-4 py-3 text-sm">${Number(m.order_total||0).toLocaleString()}</td>
                    <td class="px-4 py-3"><span class="text-xs px-2 py-1 rounded ${statusClass}">${status}</span></td>
                    <td class="px-4 py-3 text-xs text-gray-500">
                        ${joined ? new Date(joined).toLocaleDateString('en-GB', {day:'numeric', month:'short', year:'numeric'}) : 'N/A'}
                    </td>
                </tr>`;
        }).join('');

        $('#allDownlineBody').html(html || '<tr><td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No members match</td></tr>');

        const total = Object.keys(filteredAll).length;
        $('#loadMoreBtn').css('display', end >= total ? 'none' : 'block');
    }

    function loadMoreDownlines() {
        currentPage++;
        renderAll();
    }

    $(function () {
        // Recent filters
        $('#filterStatusRecent, #filterCountryRecent').on('change', renderRecent);

        // All-modal filters
        $('#filterStatusAll, #filterCountryAll').on('change', function () {
            filteredAll = filterData(allDownlines);
            currentPage = 1;
            renderAll();
        });

        // Search (modal only)
        $('#searchDownline').on('input', function () {
            const q = this.value.toLowerCase();
            filteredAll = {};
            Object.entries(allDownlines).forEach(([id, items]) => {
                const m = items[0];
                if (m.members_firstname.toLowerCase().includes(q) ||
                    m.members_username.toLowerCase().includes(q)) {
                    filteredAll[id] = items;
                }
            });
            currentPage = 1;
            renderAll();
        });

        // Initial render
        renderRecent();
        renderAll();
    });

    function openSeeAllModal() {
        $('#seeAllModal').removeClass('hidden');
        renderAll();
    }
    function closeSeeAllModal() { $('#seeAllModal').addClass('hidden'); }

    $('#seeAllModal').on('click', e => { if (e.target === e.currentTarget) closeSeeAllModal(); });
</script>
<!-- chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route("user.dashboard.activities") }}')
        .then(response => response.json())
        .then(data => {
            const timeline = document.getElementById('activities-timeline');
            const activities = data.activities;

            if (activities.length === 0) {
                timeline.innerHTML += `
                    <p class="text-gray-500 dark:text-gray-400 text-center">No activities found.</p>
                `;
                return;
            }

            activities.forEach(activity => {
                // Conditionally display amount for membership activities
                const detailText = activity.amount
                    ? `${activity.package_name} (${activity.amount})`
                    : activity.package_name;

                const activityHtml = `
                    <div class="relative mb-6 flex">
                        <div class="z-10 flex-shrink-0">
                            <img src="${activity.image}" alt="${activity.full_name}"
                                class="size-10 rounded-full object-cover ring-4 ring-white dark:ring-gray-800" />
                        </div>
                        <div class="ml-6">
                            <div class="flex items-baseline">
                                <h3 class="text-theme-sm font-semibold text-gray-800 dark:text-white/90">
                                    ${activity.full_name}
                                </h3>
                                <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                                    ${activity.action}
                                </span>
                            </div>
                            <p class="text-theme-sm font-normal text-gray-600 dark:text-gray-400">
                                ${detailText}
                            </p>
                            <p class="text-theme-xs mt-1 text-gray-500">${activity.time_ago}</p>
                        </div>
                    </div>
                `;
                timeline.innerHTML += activityHtml;
            });
        })
        .catch(error => {
            console.error('Error fetching activities:', error);
            document.getElementById('activities-timeline').innerHTML = `
                <p class="text-red-500 dark:text-red-400 text-center">Error loading activities.</p>
            `;
        });
});
</script>
<script>
    function openRankModal(conditions, title) {
        document.getElementById('modalTitle').textContent = title + ' Requirements';
        const container = document.getElementById('modalConditions');
        container.innerHTML = '';

        if (conditions.length === 0) {
            container.innerHTML = '<p class="text-gray-500">No requirements defined.</p>';
        } else {
            conditions.forEach(cond => {
                const div = document.createElement('div');
                div.className = 'mb-4';
                div.innerHTML = `
                    <div class="flex justify-between text-xs mb-1">
                        <span class="text-gray-600 dark:text-gray-300">${cond.name}</span>
                        <span>${cond.current} / ${cond.required}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-gray-600 dark:bg-blue-500 h-2 rounded-full" style="width: ${cond.bar}%"></div>
                    </div>
                `;
                container.appendChild(div);
            });
        }

        // Show the modal
        document.getElementById('rankModal').classList.remove('hidden');
    }

    // Close modal when clicking the Close button (already in HTML)
    // Optional: close when clicking outside the modal content
    document.getElementById('rankModal').addEventListener('click', function(e) {
        if (e.target === this) {
            this.classList.add('hidden');
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll('.tab-btn');
        const contents = document.querySelectorAll('.tab-content');
        const rankCards = document.getElementById('rank-cards');
        const totalCards = rankCards ? rankCards.children.length : 0;
        let currentIndex = 0;
        let autoSlideInterval;

        // Tab switching
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;

                tabs.forEach(t => {
                    t.classList.remove('bg-yellow-700', 'text-white');
                    t.classList.add('bg-gray-300', 'text-gray-700');
                });
                tab.classList.add('bg-yellow-700', 'text-white');
                tab.classList.remove('bg-gray-300', 'text-gray-700');

                contents.forEach(c => c.classList.add('hidden'));
                document.querySelector(`.tab-content[data-content="${target}"]`).classList.remove('hidden');

                if (target === 'current' && totalCards > 0) {
                    showCard(currentIndex);
                    startAutoSlide();
                } else {
                    clearInterval(autoSlideInterval);
                }
            });
        });

        function animateProgress(cardIndex) {
            const card = rankCards.children[cardIndex];
            const arc = card.querySelector('.progress-arc');
            const span = card.querySelector('.progress-text');
            if (!arc || !span) return;

            const targetPercent = parseInt(arc.dataset.target) || 0;
            const arcLength = 283;
            const targetOffset = arcLength - (arcLength * targetPercent / 100);

            arc.style.transition = 'none';
            arc.style.strokeDashoffset = arcLength;
            span.textContent = '0%';

            void arc.offsetWidth; // Trigger reflow

            setTimeout(() => {
                arc.style.transition = 'stroke-dashoffset 2s ease-in-out';
                arc.style.strokeDashoffset = targetOffset;

                let start = null;
                const duration = 2000;
                function step(timestamp) {
                    if (!start) start = timestamp;
                    const progress = Math.min((timestamp - start) / duration, 1);
                    span.textContent = Math.round(targetPercent * progress) + '%';
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                }
                requestAnimationFrame(step);
            }, 50);
        }

        function showCard(index) {
            if (!rankCards) return;
            rankCards.style.transform = `translateX(${-index * 100}%)`;
            animateProgress(index);
        }

        function nextCard() {
            currentIndex = (currentIndex + 1) % totalCards;
            showCard(currentIndex);
        }

        function prevCard() {
            currentIndex = (currentIndex - 1 + totalCards) % totalCards;
            showCard(currentIndex);
        }

        function startAutoSlide() {
            clearInterval(autoSlideInterval);
            autoSlideInterval = setInterval(nextCard, 5000);
        }

        // Navigation buttons
        document.getElementById('next-btn')?.addEventListener('click', () => {
            nextCard();
            startAutoSlide();
        });
        document.getElementById('prev-btn')?.addEventListener('click', () => {
            prevCard();
            startAutoSlide();
        });

        // Initialize current tab
        if (totalCards > 0) {
            showCard(currentIndex);
            startAutoSlide();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.0/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/confetti-js@0.1.0"></script>
<!-- Highcharts CDNs -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/maps/modules/world.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>

const dataTables = {}; // one entry per tableId


function showBlockModal(modalId, tableId, fetchUrl) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (!window[tableId + '_init']) {
        initDataTable(tableId, fetchUrl);
        window[tableId + '_init'] = true;
    }
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
}


function initDataTable(tableId, fetchUrl) {
    dataTables[tableId] = {
        recordsPerPage: 10,
        currentPage   : 1,
        totalRecords  : 0,
        isLoading     : false,
        hasMoreData   : true,
        fetchUrl
    };

    new simpleDatatables.DataTable(`#${tableId}`, {
        searchable: true,
        paging    : false,
        perPageSelect: false,
        labels: {
            placeholder: "Search ...",
            noRows     : "No records found",
            info       : ""
        }
    });

    fetchRecords(tableId); // first load
}


async function fetchRecords(tableId) {
    const dt = dataTables[tableId];
    if (dt.isLoading || !dt.hasMoreData) return;

    dt.isLoading = true;
    const url = `/user/dashboard/${dt.fetchUrl}?page=${dt.currentPage}&perPage=${dt.recordsPerPage}`;

    try {
        const res = await fetch(url);
        const json = await res.json();

        if (json.records && json.records.length) {
            updateTable(tableId, json.records, json.columns || Object.keys(json.records[0]));
            dt.totalRecords = json.total_records;
            renderPagination(tableId, json.total_records);
        } else {
            dt.hasMoreData = false;
            document.querySelector(`#${tableId} tbody`).innerHTML = '<tr><td colspan="20" class="text-center">No records found</td></tr>';
            hidePagination(tableId);
        }
    } catch (e) {
        console.error(e);
        document.querySelector(`#${tableId} tbody`).innerHTML = '<tr><td colspan="20" class="text-center text-red-500">Error loading data</td></tr>';
    } finally {
        dt.isLoading = false;
    }
}


function updateTable(tableId, records, columns) {
    const tbody = document.querySelector(`#${tableId} tbody`);
    tbody.innerHTML = '';

    records.forEach(rec => {
        const tr = document.createElement('tr');
        columns.forEach(col => {
            const td = document.createElement('td');
            td.textContent = rec[col] ?? '—';
            tr.appendChild(td);
        });
        tbody.appendChild(tr);
    });
}


function renderPagination(tableId, total) {
    const dt = dataTables[tableId];
    const pages = Math.ceil(total / dt.recordsPerPage);
    const container = document.getElementById(`${tableId}Pagination`);
    container.innerHTML = '';

    createBtn(container, 'Previous', dt.currentPage - 1, dt.currentPage === 1, tableId);

    const maxButtons = 7;
    let start = Math.max(1, dt.currentPage - Math.floor(maxButtons / 2));
    let end = Math.min(pages, start + maxButtons - 1);
    if (end - start + 1 < maxButtons) start = Math.max(1, end - maxButtons + 1);

    for (let i = start; i <= end; i++) {
        createBtn(container, i, i, i === dt.currentPage, tableId);
    }

    createBtn(container, 'Next', dt.currentPage + 1, dt.currentPage >= pages, tableId);
}

function createBtn(parent, label, page, disabled, tableId) {
    const btn = document.createElement('button');
    btn.textContent = label;
    btn.className = 'px-3 py-1 mx-1 border rounded text-sm';
    if (disabled) {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        btn.addEventListener('click', () => {
            dataTables[tableId].currentPage = page;
            fetchRecords(tableId);
        });
    }
    if (page === dataTables[tableId].currentPage) {
        btn.classList.add('bg-blue-600', 'text-white');
    }
    parent.appendChild(btn);
}

function hidePagination(tableId) {
    const el = document.getElementById(`${tableId}Pagination`);
    if (el) el.style.display = 'none';
}


function updatePerPage(tableId, perPage, fetchUrl) {
    const dt = dataTables[tableId];
    dt.recordsPerPage = parseInt(perPage);
    dt.currentPage = 1;
    fetchRecords(tableId);
}
</script>

<script>
// Wait for DOM to load
document.addEventListener("DOMContentLoaded", function () {

    const fullLink = document.getElementById("fullRefLink").value;
    const copyBtn = document.getElementById("copyRefBtn");
    const whatsappBtn = document.getElementById("shareWhatsapp");
    const generalBtn = document.getElementById("shareGeneral");



    // 2. Share on WhatsApp
    whatsappBtn.addEventListener("click", function () {
        const message = `Join me on Global Trend! Use my referral link: ${fullLink}`;
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        window.open(whatsappUrl, "_blank");
    });

    // 3. General Share (you can customize - here using Web Share API if available)
    generalBtn.addEventListener("click", function () {
        if (navigator.share) {
            navigator.share({
                title: "Join Global Trend",
                text: "Use my referral link to join!",
                url: fullLink
            }).catch(err => console.log("Share failed", err));
        } else {
            // Fallback: open Facebook share (or any other)
            const fbUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(fullLink)}`;
            window.open(fbUrl, "_blank");
        }
    });
      // 1. Copy to Clipboard
    copyBtn.addEventListener("click", function () {
        navigator.clipboard.writeText(fullLink).then(() => {
            // Show success feedback
            copyBtn.innerHTML = '<span class="text-green-600">Copied!</span>';
            setTimeout(() => {
                copyBtn.innerHTML = `
                    <svg class="w-5 h-5 text-yellow-700 dark:text-yellow-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M9 8v3a1 1 0 0 1-1 1H5m11 4h2a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1h-7a1 1 0 0 0-1 1v1m4 3v10a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1v-7.13a1 1 0 0 1 .24-.65L7.7 8.35A1 1 0 0 1 8.46 8H13a1 1 0 0 1 1 1Z" />
                            </svg>
                `;
            }, 2000);
        }).catch(err => {
            console.error("Copy failed", err);
        });
    });

});
</script>
<!-- order chart -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route("user.dashboard.getorderstats") }}')
        .then(response => response.json())
        .then(data => {
            // Update total orders count
            document.getElementById('total-orders').textContent = data.total_orders || '0';

            // Destroy old chart if exists (prevents memory leak on theme change)
            if (window.deliveryChartInstance) {
                window.deliveryChartInstance.destroy();
            }

            // Create new chart with real backend data
            const ctx = document.getElementById('deliveryChart').getContext('2d');
            window.deliveryChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.chart.labels || ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [
                        {
                            label: "Delivered",
                            data: data.chart.delivered || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: "#E0D0A8",  // your exact color
                            borderRadius: 8
                        },
                        {
                            label: "Orders",
                            data: data.chart.orders || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                            backgroundColor: "#BB9856",   // your exact color
                            borderRadius: 8
                        }
                    ]
                },
                 options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "top",
                            labels: {
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: { size: 10 },
                            },

                            grid: { color: getGridColor() }
                        },
                        x: {
                            ticks: {
                                font: { size: 10, }
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching order stats:', error);
            // Optional: show fallback message or keep dummy chart
        });

        // dynamic colors based on theme
        function getTextColor() {
            return document.documentElement.classList.contains("dark") ? "#e5e7eb" : "#374151";
        }
        function getGridColor() {
            return document.documentElement.classList.contains("dark") ? "#4b5563" : "#e5e7eb";
        }

        let deliveryChart = createChart();

        // Recreate chart when theme changes
        window.addEventListener("DOMContentLoaded", () => {
            const observer = new MutationObserver(() => {
                deliveryChart.destroy();
                deliveryChart = createChart();
            });
            observer.observe(document.documentElement, { attributes: true });
        });

    // Recreate chart when dark/light theme changes (keeps your original behavior)
    const observer = new MutationObserver(() => {
        // Re-fetch or just re-apply colors if needed
        // For simplicity, we destroy & recreate on theme change
        if (window.deliveryChartInstance) {
            window.deliveryChartInstance.destroy();
            // You can re-call the fetch here if you want fresh data on theme change
            // Or just let it keep old data with new colors
        }
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ["class"] });
});
</script>


<!-- JavaScript -->
<script>
function showDetail(type) {
    const labelEl = document.getElementById('detail-label');
    const valueEl = document.getElementById('detail-value');

    if (type === 'withdrawal') {
        labelEl.textContent = 'Total Withdrawn :';
        valueEl.textContent = '{{ $currency ?? '$' }}{{ number_format($totalWithdrawn ?? 0, 2) }}';
    } else if (type === 'transfer') {
        labelEl.textContent = 'Total Transferred :';
        valueEl.textContent = '{{ $currency ?? '$' }}{{ number_format($totalDebited ?? 0, 2) }}';
    }

    valueEl.parentElement.classList.add('animate-pulse-once');
    setTimeout(() => {
        valueEl.parentElement.classList.remove('animate-pulse-once');
    }, 800);
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('{{ route("user.dashboard.getorderstats") }}')
            .then(response => response.json())
            .then(data => {
                // Update total orders
                document.getElementById('total-orders').textContent = data.total_orders;

                // Update stats (PV, GPV, active/paid members)
                document.getElementById('pv-value').textContent = data.stats.pv || 0;
                document.getElementById('gpv-value').textContent = data.stats.gpv || 0;
                document.getElementById('active-members').textContent = data.stats.active_members || 0;
                document.getElementById('paid-members').textContent = data.stats.paid_members || 0;

                // Render Chart
                new Chart(document.getElementById('orderChart'), {
                     type: 'bar',
                     data: {
                        labels: data.chart.labels,
                        datasets: [
                            {
                                label: 'Delivered',
                                data: data.chart.delivered,
                                backgroundColor: 'rgba(147, 197, 253, 0.8)',
                                borderRadius: 6

                            },
                            {
                                label: 'Orders',
                                data: data.chart.orders,
                                backgroundColor: 'rgba(37, 99, 235, 0.9)',
                                borderRadius: 6

                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false }
                             },

                        scales: {
                            y: { beginAtZero: true, grid: { display: false } },
                            x: { ticks: {
                                        font: { size: 10, }
                                    },
                                    grid: { display: false },
                                }

                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching order stats:', error));
    });
</script>




<!-- dropdown and header scripts -->
   <script>

  // Get the CSS variable --color-brand and convert it to hex for ApexCharts
  const getBrandColor = () => {
    // Get the computed style of the document's root element
    const computedStyle = getComputedStyle(document.documentElement);

    // Get the value of the --color-brand CSS variable
    return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#E0D0A8";
  };

  const getBrandSecondaryColor = () => {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue('--color-fg-brand-subtle').trim() || "#BB9856";
  };

  const brandColor = getBrandColor();
  const brandSecondaryColor = getBrandSecondaryColor();

  const option = {
    colors: [brandColor, brandSecondaryColor],
    series: [
      {
        name: "Organic",
        color: brandColor,
        data: [
          { x: "Mon", y: 231 },
          { x: "Tue", y: 122 },
          { x: "Wed", y: 63 },
          { x: "Thu", y: 421 },
          { x: "Fri", y: 122 },
          { x: "Sat", y: 323 },
          { x: "Sun", y: 111 },
        ],
      },
      {
        name: "Social media",
        color: brandSecondaryColor,
        data: [
          { x: "Mon", y: 232 },
          { x: "Tue", y: 113 },
          { x: "Wed", y: 341 },
          { x: "Thu", y: 224 },
          { x: "Fri", y: 522 },
          { x: "Sat", y: 411 },
          { x: "Sun", y: 243 },
        ],
      },
    ],
    chart: {
      type: "bar",
      height: "250px",
      fontFamily: "Inter, sans-serif",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "70%",
        borderRadiusApplication: "end",
        borderRadius: 8,
      },
    },
    tooltip: {
      shared: true,
      intersect: false,
      style: {
        fontFamily: "Inter, sans-serif",
      },
    },
    states: {
      hover: {
        filter: {
          type: "darken",
          value: 1,
        },
      },
    },
    stroke: {
      show: true,
      width: 0,
      colors: ["transparent"],
    },
    grid: {
      show: false,
      strokeDashArray: 4,
      padding: {
        left: 2,
        right: 2,
        top: -14
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    xaxis: {
      floating: false,
      labels: {
        show: true,
        style: {
          fontFamily: "Inter, sans-serif",
          cssClass: 'text-xs font-normal fill-body'
        }
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      show: false,
    },
    fill: {
      opacity: 1,
    },
  }

  if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("column-chart"), option);
    chart.render();
  }



        </script>
             <script>

    // Get the CSS variable --color-brand and convert it to hex for ApexCharts
    const getBrandColor1 = () => {
        // Get the computed style of the document's root element
        const computedStyle = getComputedStyle(document.documentElement);

        // Get the value of the --color-brand CSS variable
        return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#BB9856";
    };

    const getBrandSecondaryColor1 = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-fg-brand-subtle').trim() || "#E0D0A8";
    };

    const getBrandTertiaryColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-fg-brand-strong').trim() || "#CDB379";
    };

    const getNeutralPrimaryColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-neutral-primary').trim() || "#FFFFFF";
    };

    const brandColor1 = getBrandColor1();
    const brandSecondaryColor1 = getBrandSecondaryColor1();
    const brandTertiaryColor = getBrandTertiaryColor();
    const neutralPrimaryColor = getNeutralPrimaryColor();

    const getChartOptions = () => {
        return {
        series: [52.8, 26.8, 20.4],
        colors: [brandColor1, brandSecondaryColor1, brandTertiaryColor],
        chart: {
            height: "250px",
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: [neutralPrimaryColor],
            lineCap: "",
        },
        plotOptions: {
            pie: {
            labels: {
                show: true,
            },
            size: "100%",
            dataLabels: {
                offset: -25
            }
            },
        },
        labels: ["Direct", "Organic search", "Referrals"],
        dataLabels: {
            enabled: true,
            style: {
            fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
            formatter: function (value) {
                return value + "%"
            },
            },
        },
        xaxis: {
            labels: {
            formatter: function (value) {
                return value  + "%"
            },
            },
            axisTicks: {
            show: false,
            },
            axisBorder: {
            show: false,
            },
        },
        }
    }

    if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
    }


        </script>
        <script>


// Get the CSS variable --color-brand and convert it to hex for ApexCharts
const getBrandColor3 = () => {
  // Get the computed style of the document's root element
  const computedStyle = getComputedStyle(document.documentElement);

  // Get the value of the --color-brand CSS variable
  return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#1447E6";
};

const brandColor3 = getBrandColor3();

const options3 = {
  chart: {
    height: "50px",
    maxWidth: "50px",
    type: "area",
    fontFamily: "Inter, sans-serif",
    dropShadow: {
      enabled: false,
    },
    toolbar: {
      show: false,
    },
  },
  tooltip: {
    enabled: true,
    x: {
      show: false,
    },
  },
  fill: {
    type: "gradient",
    gradient: {
      opacityFrom: 0.55,
      opacityTo: 0,
      shade: brandColor3,
      gradientToColors: [brandColor3],
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    width: 6,
  },
  grid: {
    show: false,
    strokeDashArray: 4,
    padding: {
      left: 2,
      right: 2,
      top: 0
    },
  },
  series: [
    {
      name: "New users",
      data: [6500, 6418, 6456, 6526, 6356, 6456],
      color: brandColor3,
    },
  ],
  xaxis: {
    categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
    labels: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
    axisTicks: {
      show: false,
    },
  },
  yaxis: {
    show: false,
  },
}

if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
  const chart = new ApexCharts(document.getElementById("area-chart"), options3);
  chart.render();
}
        </script>

        <script>
        // Create a single shared external tooltip element
        const tooltipEl = document.createElement('div');
        tooltipEl.id = 'chartjs-tooltip';
        tooltipEl.className = 'absolute px-4 py-2 text-xs font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 transition-opacity duration-200 pointer-events-none z-50';
        tooltipEl.innerHTML = `
            <div class="relative">
                <div class="tooltip-content"></div>
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-full w-0 h-0 border-l-8 border-r-8 border-t-8 border-transparent border-t-gray-200"></div>
            </div>
        `;
        document.body.appendChild(tooltipEl);
        const tooltipContent = tooltipEl.querySelector('.tooltip-content');

        // External tooltip handler (shared for both charts)
        const externalTooltipHandler = (context) => {
            const {chart, tooltip} = context;

            if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = '0';
                return;
            }

            // Set custom text
            if (tooltip.body) {
                const titleLines = tooltip.title || [];
                const bodyLines = tooltip.body.map(b => b.lines);

                let innerHtml = '';
                if (titleLines.length > 0) {
                    innerHtml += `<div class="text-xs text-gray-500 mb-1">${titleLines[0]}</div>`;
                }
                innerHtml += `<div class="font-semibold">${bodyLines[0][0]}</div>`;
                tooltipContent.innerHTML = innerHtml;
            }

            // Positioning
            const canvas = chart.canvas;
            const rect = canvas.getBoundingClientRect();

            // Position tooltip above the point
            tooltipEl.style.opacity = '1';
            tooltipEl.style.left = rect.left + window.scrollX + tooltip.caretX + 'px';
            tooltipEl.style.top = rect.top + window.scrollY + tooltip.caretY + 'px';
            tooltipEl.style.transform = 'translate(-50%, -110%)';
        };

        // Churn Rate Chart
        new Chart(document.getElementById('totalcommission'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Churn Rate',
                    data: [4.1, 3.9, 4.3, 4.5, 4.2, 4.3, 4.26],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: false, // Disable default tooltip
                        external: externalTooltipHandler,
                        callbacks: {
                            title: (context) => context[0].label,
                            label: (context) => `Total Commission: ${context.parsed.y.toFixed(2)}%`
                        }
                    }
                },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: {
                    point: {
                        radius: 0,
                        hoverRadius: 6,
                        hoverBackgroundColor: '#fff',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#ef4444'
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // Package Purchased Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'New Signups',
                    data: [3200, 3400, 3500, 3600, 3650, 3700, 3768],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: false,
                        external: externalTooltipHandler,
                        callbacks: {
                            title: (context) => context[0].label,
                            label: (context) => `Package Purchased: $${context.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: {
                    point: {
                        radius: 0,
                        hoverRadius: 6,
                        hoverBackgroundColor: '#fff',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#10b981'
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });

        // New Enrollment Chart
        new Chart(document.getElementById('newenrollmentChart'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: [100, 200, 400, 600, 500, 600, 700],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: false,
                        external: externalTooltipHandler,
                        callbacks: {
                            title: (context) => context[0].label,
                            label: (context) => `New Enrollment : ${context.parsed.y.toLocaleString()}`
                        }
                    }
                },
                scales: {
                    x: { display: false },
                    y: { display: false }
                },
                elements: {
                    point: {
                        radius: 0,
                        hoverRadius: 6,
                        hoverBackgroundColor: '#fff',
                        hoverBorderWidth: 3,
                        hoverBorderColor: '#ef4444'
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        });
    </script>

        <script>

  // Get the CSS variable --color-brand and convert it to hex for ApexCharts
  const getBrandColor32 = () => {
    // Get the computed style of the document's root element
    const computedStyle = getComputedStyle(document.documentElement);

    // Get the value of the --color-brand CSS variable
    return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#8F6B3A";
  };

  const getWarningColor = () => {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue('--color-warning').trim() || "#CDB379";
  };

  const getSuccessColor = () => {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue('--color-success').trim() || "#E0D0A8";
  };
  const getNeutralSecondaryMediumColor = () => {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue('--color-neutral-secondary-medium').trim() || "#FFFFFF";
  };


  const brandColor2 = getBrandColor2();
  const warningColor = getWarningColor();
  const successColor = getSuccessColor();
  const neutralSecondaryMediumColor = getNeutralSecondaryMediumColor();

  const getChartOptions2 = () => {
    return {
      series: [90, 85, 70],
      colors: [brandColor2, warningColor, successColor],
      chart: {
        height: "350px",
        width: "100%",
        type: "radialBar",
        sparkline: {
          enabled: true,
        },
      },
      plotOptions: {
        radialBar: {
          track: {
            background: neutralSecondaryMediumColor,
          },
          dataLabels: {
            show: false,
          },
          hollow: {
            margin: 0,
            size: "32%",
          }
        },
      },
      grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
          left: 2,
          right: 2,
          top: -23,
          bottom: -20,
        },
      },
      labels: ["To do", "In progress", "Done"],
      legend: {
        show: true,
        position: "bottom",
        fontFamily: "Inter, sans-serif",
      },
      tooltip: {
        enabled: true,
        x: {
          show: false,
        },
      },
      yaxis: {
        show: false,
        labels: {
          formatter: function (value) {
            return value + '%';
          }
        }
      }
    }
  }

  if (document.getElementById("radial-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.querySelector("#radial-chart"), getChartOptions2());
    chart.render();
  }

        </script>

        <script>

  // Get the CSS variable --color-brand and convert it to hex for ApexCharts
  const getBrandColor = () => {
    // Get the computed style of the document's root element
    const computedStyle = getComputedStyle(document.documentElement);

    // Get the value of the --color-brand CSS variable
    return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#E0D0A8";
  };

  const getBrandSecondaryColor = () => {
    const computedStyle = getComputedStyle(document.documentElement);
    return computedStyle.getPropertyValue('--color-fg-brand-subtle').trim() || "#BB9856";
  };

  const brandColor = getBrandColor();
  const brandSecondaryColor = getBrandSecondaryColor();

  const option = {
    colors: [brandColor, brandSecondaryColor],
    series: [
      {
        name: "Organic",
        color: brandColor,
        data: [
          { x: "Mon", y: 231 },
          { x: "Tue", y: 122 },
          { x: "Wed", y: 63 },
          { x: "Thu", y: 421 },
          { x: "Fri", y: 122 },
          { x: "Sat", y: 323 },
          { x: "Sun", y: 111 },
        ],
      },
      {
        name: "Social media",
        color: brandSecondaryColor,
        data: [
          { x: "Mon", y: 232 },
          { x: "Tue", y: 113 },
          { x: "Wed", y: 341 },
          { x: "Thu", y: 224 },
          { x: "Fri", y: 522 },
          { x: "Sat", y: 411 },
          { x: "Sun", y: 243 },
        ],
      },
    ],
    chart: {
      type: "bar",
      height: "250px",
      fontFamily: "Inter, sans-serif",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "70%",
        borderRadiusApplication: "end",
        borderRadius: 8,
      },
    },
    tooltip: {
      shared: true,
      intersect: false,
      style: {
        fontFamily: "Inter, sans-serif",
      },
    },
    states: {
      hover: {
        filter: {
          type: "darken",
          value: 1,
        },
      },
    },
    stroke: {
      show: true,
      width: 0,
      colors: ["transparent"],
    },
    grid: {
      show: false,
      strokeDashArray: 4,
      padding: {
        left: 2,
        right: 2,
        top: -14
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    xaxis: {
      floating: false,
      labels: {
        show: true,
        style: {
          fontFamily: "Inter, sans-serif",
          cssClass: 'text-xs font-normal fill-body'
        }
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      show: false,
    },
    fill: {
      opacity: 1,
    },
  }

  if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("column-chart"), option);
    chart.render();
  }



        </script>

        <script>

    // Get the CSS variable --color-brand and convert it to hex for ApexCharts
    const getBrandColor1 = () => {
        // Get the computed style of the document's root element
        const computedStyle = getComputedStyle(document.documentElement);

        // Get the value of the --color-brand CSS variable
        return computedStyle.getPropertyValue('--color-fg-brand').trim() || "#BB9856";
    };

    const getBrandSecondaryColor1 = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-fg-brand-subtle').trim() || "#E0D0A8";
    };

    const getBrandTertiaryColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-fg-brand-strong').trim() || "#CDB379";
    };

    const getNeutralPrimaryColor = () => {
        const computedStyle = getComputedStyle(document.documentElement);
        return computedStyle.getPropertyValue('--color-neutral-primary').trim() || "#FFFFFF";
    };

    const brandColor1 = getBrandColor1();
    const brandSecondaryColor1 = getBrandSecondaryColor1();
    const brandTertiaryColor = getBrandTertiaryColor();
    const neutralPrimaryColor = getNeutralPrimaryColor();

    const getChartOptions = () => {
        return {
        series: [52.8, 26.8, 20.4],
        colors: [brandColor1, brandSecondaryColor1, brandTertiaryColor],
        chart: {
            height: "250px",
            width: "100%",
            type: "pie",
        },
        stroke: {
            colors: [neutralPrimaryColor],
            lineCap: "",
        },
        plotOptions: {
            pie: {
            labels: {
                show: true,
            },
            size: "100%",
            dataLabels: {
                offset: -25
            }
            },
        },
        labels: ["Direct", "Organic search", "Referrals"],
        dataLabels: {
            enabled: true,
            style: {
            fontFamily: "Inter, sans-serif",
            },
        },
        legend: {
            position: "bottom",
            fontFamily: "Inter, sans-serif",
        },
        yaxis: {
            labels: {
            formatter: function (value) {
                return value + "%"
            },
            },
        },
        xaxis: {
            labels: {
            formatter: function (value) {
                return value  + "%"
            },
            },
            axisTicks: {
            show: false,
            },
            axisBorder: {
            show: false,
            },
        },
        }
    }

    if (document.getElementById("pie-chart") && typeof ApexCharts !== 'undefined') {
        const chart = new ApexCharts(document.getElementById("pie-chart"), getChartOptions());
        chart.render();
    }


        </script>



        <!-- Trending products js -->
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.getElementById("cardSlider");
            const cards = slider.children;
            const totalCards = cards.length;
            let index = 0;

            const nextBtn = document.getElementById("nextBtn");
            const prevBtn = document.getElementById("prevBtn");

            function updateSlider() {
                slider.style.transform = `translateX(-${index * 100}%)`;
            }

            nextBtn.addEventListener("click", () => {
                index = (index + 1) % totalCards; // loop to first card
                updateSlider();
            });

            prevBtn.addEventListener("click", () => {
                index = (index - 1 + totalCards) % totalCards; // loop to last card
                updateSlider();
            });

            // Optional Auto Slide every 4 seconds
            setInterval(() => {
                index = (index + 1) % totalCards;
                updateSlider();
            }, 4000);
        });
    </script>

        <!-- World map graph -->
        <script>

        const tooltip = document.getElementById("map-tooltip");

        const dataSet = {
            CHN: { active: { value: '1,408' }, fillKey: 'MAJOR', short: 'cn' },
            IND: { active: { value: '5,101' }, fillKey: 'MAJOR', short: 'in' },
            USA: { active: { value: '10,101' }, fillKey: 'MAJOR', short: 'us' }
        };

        const map = new Datamap({
            element: document.getElementById("hs-users-datamap"),
            projection: "mercator",
            fills: {
                defaultFill: "#d1d5db",
                MAJOR: "#3F83F8"
            },
            data: dataSet,
            geographyConfig: {
                popupOnHover: false,
                highlightFillColor: "#3b82f6",
                highlightBorderColor: "#3b82f6",
                borderColor: "rgba(0,0,0,.2)"
            },

            // ⭐ IMPORTANT FOR TOOLTIP EVENTS
            done: function (datamap) {

                datamap.svg.selectAll('.datamaps-subunit')
                    .on('mouseover', function (geo) {
                        const code = geo.id;
                        const data = dataSet[code];
                        if (!data) return;

                        // ⭐ Add highlight effect manually
                        d3.select(this)
                            .transition().duration(50)
                            .style("fill", "#1C64F2")
                            .style("stroke", "#1C64F2")
                            .style("stroke-width", "1");

                        //         tooltip.innerHTML = `
                        // <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-auto p-3">
                        //     <div class="flex items-center mb-2">
                        //         <img src="https://cdn.jsdelivr.net/npm/svg-country-flags/svg/${data.short}.svg"
                        //         class="w-4 h-4 rounded-full mr-2">
                        //         <span class="text-xs">${data.customName || geo.properties.name}</span>
                        //     </div>
                        //     <div class="text-xs text-gray-700 dark:text-gray-300">
                        //         <div class="text-xs"><b>Active:</b> ${data.active.value}
                        //             <span class="${data.active.isGrown ? 'text-green-500' : 'text-red-500'}">${data.active.percent}%</span>
                        //         </div>
                        //         <div class="text-xs"><b>New:</b> ${data.new.value}
                        //             <span class="${data.new.isGrown ? 'text-green-500' : 'text-red-500'}">${data.new.percent}%</span>
                        //         </div>
                        //     </div>
                        // </div>`;

                        //         tooltip.style.display = "block";
                    })

                    .on('mousemove', function (geo, d, evt) {
                        const e = evt || d3.event;
                        tooltip.style.top = (e.pageY + 10) + "px";
                        tooltip.style.left = (e.pageX + 10) + "px";
                    })

                    .on('mouseout', function () {

                        // ⭐ Remove highlight → restore original color
                        d3.select(this)
                            .transition().duration(50)
                            .style("fill", function (d) {
                                const code = d.id;
                                return dataSet[code]?.fillKey === "MAJOR"
                                    ? "#3F83F8"     // major country color
                                    : "#d1d5db";    // default fill
                            })
                            .style("stroke", "rgba(0,0,0,.2)");

                        tooltip.style.display = "";
                    });
            }

        });

        // INITIAL DRAW
        drawMap();

        // ⭐ REDRAW MAP WHEN THEME CHANGES (Tailwind Dark Mode Toggle)
        const observer = new MutationObserver(() => {
            drawMap();
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ["class"]
        });


    </script>

        <!-- Sales graph.js -->
        <script>
        document.addEventListener("DOMContentLoaded", function () {

            const isDark = document.documentElement.classList.contains("dark");

            const textColor = isDark ? "#d1d5db" : "#4b5563";
            const borderColor = isDark ? "#374151" : "#e5e7eb";

            const totalValue = 2450;

            // Plugin to draw center text
            const centerTextPlugin = {
                id: "centerText",
                beforeDraw(chart, args, options) {   // <-- moved from afterDraw to beforeDraw
                    const { ctx, chartArea: { width, height } } = chart;

                    const isDark = document.documentElement.classList.contains("dark");
                    const textColor = isDark ? "#d1d5db" : "#4b5563";
                    const totalValue = options.totalValue || 2450;

                    ctx.save();
                    ctx.font = "bold 22px Inter";
                    ctx.fillStyle = textColor;
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";
                    ctx.fillText(totalValue, width / 2, height / 2);
                    ctx.restore();

                    ctx.save();
                    ctx.font = "12px Inter";
                    ctx.fillStyle = textColor;
                    ctx.textAlign = "center";
                    ctx.fillText("Total", width / 2, height / 2 - 28);
                    ctx.restore();
                }
            };


            const ctx = document.getElementById("salesChart").getContext("2d");

            new Chart(ctx, {
                type: "doughnut",
                plugins: [centerTextPlugin],
                data: {
                    labels: ["Affiliate Program", "Direct Buy", "Adsense"],
                    datasets: [
                        {
                            data: [2040, 1402, 510],
                            backgroundColor: [
                                "rgb(37, 99, 235)",    // blue-600
                                "rgb(96, 165, 250)",   // blue-400
                                "rgb(191, 219, 254)"   // blue-200
                            ],
                            borderWidth: 2,
                            borderColor: borderColor,
                            cutout: "70%",
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            enabled: true,
                            backgroundColor: isDark ? "#1f2937" : "#F9FAFB", // solid opaque
                            titleColor: textColor,
                            bodyColor: textColor,
                            borderColor: borderColor,
                            borderWidth: 1,
                            displayColors: false,
                            padding: 10,
                            z: 10
                        }
                    }

                }
            });
        });

    </script>

        <script>
    // Select all dropdown toggles
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.stopPropagation();

        const parent = this.closest('.relative');
        const menu = parent.querySelector('.dropdown-menu');

        // Check if this menu is currently open
        const isCurrentlyOpen = !menu.classList.contains('hidden');

        // Close ALL dropdowns first
        document.querySelectorAll('.dropdown-menu').forEach(m => {
          m.classList.add('hidden');
        });

        // If it wasn't open before closing all, reopen this one
        if (!isCurrentlyOpen) {
          menu.classList.remove('hidden');
        }
      });
    });

    // Close all dropdowns when clicking outside the navbar
    document.addEventListener('click', function(e) {
      if (!e.target.closest('nav')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
          menu.classList.add('hidden');
        });
      }
    });

    // Optional: Prevent menu clicks from closing the dropdown
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
      menu.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });
        </script>

        <!--distributor-table-script-->
        <script>
        if (document.getElementById("default-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#default-table", {
                searchable: false,
                perPageSelect: false
            });
        }
    </script>

        <!--Chat-inside-script-->
        <script>
        const button = document.getElementById('setting');
        const dropdown = document.getElementById('dropdown-content');

        button.addEventListener('click', function () {
            dropdown.classList.toggle('hidden');
        });
    </script>

        <!--Chat-inside-script-->
        <script>

        const options = {
            chart: {
                // add these lines to update the size of the chart
                height: 240,
                width: 240,
                type: "area",
                fontFamily: "Inter, sans-serif",
                dropShadow: {
                    enabled: false,
                },
                toolbar: {
                    show: false,
                },
            },
            tooltip: {
                enabled: true,
                x: {
                    show: false,
                },
            },
            fill: {
                type: "gradient",
                gradient: {
                    opacityFrom: 0.55,
                    opacityTo: 0,
                    shade: "#1C64F2",
                    gradientToColors: ["#1C64F2"],
                },
            },
            dataLabels: {
                enabled: false,
            },
            stroke: {
                width: 6,
            },
            grid: {
                show: false,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -26
                },
            },
            series: [
                {
                    name: "Developer Edition",
                    data: [1500, 1418, 1456, 1526, 1356, 1256],
                    color: "#1A56DB",
                },
                {
                    name: "Designer Edition",
                    data: [643, 413, 765, 412, 1423, 1731],
                    color: "#7E3BF2",
                },
            ],
            xaxis: {
                categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
                labels: {
                    show: false,
                },
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
            },
            yaxis: {
                show: false,
                labels: {
                    formatter: function (value) {
                        return '$' + value;
                    }
                }
            },
        }

        if (document.getElementById("size-chart") && typeof ApexCharts !== 'undefined') {
            const chart = new ApexCharts(document.getElementById("size-chart"), options);
            chart.render();
        }

    </script>

        <!-- responsive script  -->
        <script>
        const toggleBtnx = document.getElementById('asidexToggle');
        const asidex = document.getElementById('asidex');

        toggleBtnx.addEventListener('click', () => {
            asidex.classList.toggle('-translate-x-full');
        });
    </script>

        <!-- dark and light theme -->
        <script>
        const toggle = document.getElementById('themeToggle');

        // Check and apply stored theme
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark');
            toggle.checked = true;
        } else {
            document.documentElement.classList.remove('dark');
            toggle.checked = false;
        }

        // Toggle listener
        toggle.addEventListener('change', function () {
            if (this.checked) {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            }
        });
    </script>

        <!-- userlogo dropdown -->
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdown = document.getElementById("user-dropdown");
            const toggleBtn = document.getElementById("user-menu-button");
            let isOpen = false;

            // Toggle dropdown on button click
            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation();
                isOpen = !isOpen;
                dropdown.classList.toggle("hidden", !isOpen);
            });

            // Close dropdown when clicking inside
            dropdown.addEventListener("click", function (e) {
                e.stopPropagation();
                dropdown.classList.add("hidden");
                isOpen = false;
            });

            // Close dropdown when clicking outside
            document.addEventListener("click", function () {
                if (isOpen) {
                    dropdown.classList.add("hidden");
                    isOpen = false;
                }
            });
        });
    </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('notifyToggle');
            const dropdown = document.getElementById('notifyDropdown');
            const closeBtn = document.getElementById('notifyClose');

            // Toggle dropdown
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            // Close button
            closeBtn.addEventListener('click', () => {
                dropdown.classList.add('hidden');
            });

            // Click outside closes dropdown
            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
                dropdown.classList.add('hidden');
                }
            });
            });
        </script>

        <script src="js/bundle.js"></script>



@endsection
