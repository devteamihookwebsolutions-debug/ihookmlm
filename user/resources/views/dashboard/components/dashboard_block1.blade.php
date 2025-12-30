<div class="mx-auto  p-4 md:p-6">
        <!-- #endregion -->
    <div class="space-y-6 dark:border-gray-100">
    <!-- 1st Row Start -->
        <div
            class="rounded-2xl bg-gray-100 border border-gray-200 p-6 dark:bg-gray-900 dark:border-gray-800">
            <div
                class="mb-5 flex flex-col justify-between gap-4 sm:flex-row sm:items-center dark:bg-gary-900">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 dark:text-white">
                        Overview
                    </h3>
                </div>
                <div class="flex gap-x-2 ">
                    <div x-data="{selected: 'weekly'}"
                        class="inline-flex w-full items-center gap-2 rounded-lg bg-gray-100 p-0.5 dark:bg-gray-900 dark:border-gray-800">
                        <button @click="selected = 'weekly'"
                            :class="selected === 'weekly' ? 'shadow-xs text-gray-900 bg-white dark:text-white dark:bg-gray-900' : 'text-gray-500 dark:text-blue-500'"
                            class="text-sm w-full border border-gray-300 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white text-gray-900 dark:text-blue-500 dark:bg-gray-900 dark:border-gray-800">
                            Weekly
                        </button>
                        <button @click="selected = 'monthly'"
                            :class="selected === 'monthly' ? 'shadow-xs text-gray-900 dark:text-white bg-white dark:bg-gray-900' : 'text-gray-500 dark:text-blue-500'"
                            class="text-sm w-full border border-gray-300 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-blue-500 dark:border-gray-800">
                            Monthly
                        </button>
                        <button @click="selected = 'yearly'"
                            :class="selected === 'yearly' ? 'shadow-theme-xs text-gray-900 dark:text-white bg-white dark:bg-gray-900' : 'text-gray-500 dark:text-blue-500'"
                            class="text-sm w-full border border-gray-300 rounded-md px-3 py-2 font-medium hover:text-gray-900 dark:hover:text-white text-gray-500 dark:text-blue-500 dark:border-gray-800">
                            Yearly
                        </button>
                    </div>
                    <div>
                        <button
                            class="text-sm shadow-xs inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white p-2 font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-800 dark:bg-gray-900 dark:text-blue-500 dark:hover:bg-gray-900 dark:hover:text-white dark:border-gray-800">
                            <svg class="fill-white stroke-current dark:fill-gray-800" width="20"
                                height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M2.29004 5.90393H17.7067" stroke="" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M17.7075 14.0961H2.29085" stroke="" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                <path
                                    d="M12.0826 3.33331C13.5024 3.33331 14.6534 4.48431 14.6534 5.90414C14.6534 7.32398 13.5024 8.47498 12.0826 8.47498C10.6627 8.47498 9.51172 7.32398 9.51172 5.90415C9.51172 4.48432 10.6627 3.33331 12.0826 3.33331Z"
                                    fill="" stroke="" stroke-width="1.5"></path>
                                <path
                                    d="M7.91745 11.525C6.49762 11.525 5.34662 12.676 5.34662 14.0959C5.34661 15.5157 6.49762 16.6667 7.91745 16.6667C9.33728 16.6667 10.4883 15.5157 10.4883 14.0959C10.4883 12.676 9.33728 11.525 7.91745 11.525Z"
                                    fill="" stroke="" stroke-width="1.5"></path>
                            </svg>
                            <span class="hidden sm:block">Filter</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="grid md:grid-cols-4 gap-5 ">

                {{-- ==================== PROFILE CARD ==================== --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-md h-fit overflow-hidden dark:bg-gray-900 dark:border-gray-800">
                    <div class="relative bg-[url('/img/profile-bg-3.jpg')] bg-cover bg-center md:h-28 h-28">
                        <div class="absolute left-1/2 transform -translate-x-1/2 ml-7 bottom-[-32px]">
                            <div class="h-16 w-16 bg-white rounded-full border-4 border-yellow-500">
                                <img src="{{ $block2details['membersimage'] ?? '/img/av-ico-2.png' }}" alt="profile" class="rounded-full object-cover w-full h-full">
                            </div>
                        </div>
                    </div>

                    <div class="pt-10 px-6 pb-6 text-center">
                        <h2 class="font-medium text-xs text-gray-800 dark:text-white mt-1">
                            {{ $member->members_firstname ?? '' }} {{ $member->members_lastname ?? '' }}
                        </h2>

                     <p class="text-[8px] text-yellow-500">EXECUTIVE RANKS</p>

                        @php
                            $hasAchievedRank = false;
                        @endphp

                        @forelse($userRanks as $rank)
                            @if($rank['progress'] == '100%' || $rank['progress'] == '100')
                                @php
                                    $hasAchievedRank = true;
                                @endphp
                                <p class="text-gray-600 text-[10px] font-medium mt-1 mb-5 dark:text-gray-500">
                                    {{ $rank['rank_title'] }}
                                </p>
                            @endif
                        @empty
                        @endforelse
                        @if(!$hasAchievedRank && !empty($userRanks))
                            <p class="text-gray-600 text-[10px] font-medium mt-1 mb-5 dark:text-gray-500">
                                No Rank Achieved
                            </p>
                        @endif

                        <div class="bg-gray-100 mb-5 border border-gray-200 rounded-full py-2 my-3 dark:bg-gray-900 dark:border-gray-800">
                            <p class="text-xs text-gray-800 dark:text-gray-300">{{ $member_id ?? $member->members_id }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-500">
                                {{ $member_date ?? ($member->members_doj ? \Carbon\Carbon::parse($member->members_doj)->format('d M Y') : '') }}
                            </p>
                        </div>

                        <div class="border-t border-gray-200 pt-5 text-xs text-gray-800 dark:text-gray-300">
                            <p class="mb-1">My Sponsor</p>
                            <p class="text-xs text-gray-600 dark:text-gray-500">
                                {{ $block2details['sponsor_fullname'] ?? '—' }}
                            </p>
                            <p class="text-xs text-blue-500 underline">
                                {{ $member->members_email ?? '—' }}
                            </p>
                        </div>

                        <div class="mt-4">
                            <p class="text-xs text-gray-800 mb-1 dark:text-gray-300">Package Name</p>
                            <p class="font-medium text-xs text-gray-600 dark:text-gray-500">
                                {{ $block2details['package_name'] ?? '—' }}
                            </p>
                            <button class="mt-5 px-4 py-1 bg-gray-800 hover:bg-gray-900 text-white text-sm rounded-full
                                        dark:bg-blue-500 dark:hover:bg-blue-600">
                                Update Package
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ==================== MY WALLET ==================== --}}
                <div>
                <!-- My wallet -->
                <div>
                    <div class="bg-[url('/img/profile-bg-2.jpg')] bg-center rounded-2xl text-white p-5 shadow-md">
                        <div class="flex justify-between">
                            <h2 class="text-xs">YOUR WALLET AMOUNT</h2>
                            <svg class="w-6 h-6 text-white" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="M2.9917 4.9834V18.917M9.96265 4.9834V18.917M15.9378 4.9834V18.917m2.9875-13.9336V18.917" />
                                <path stroke="currentColor" stroke-linecap="round"
                                    d="M5.47925 4.4834V19.417m1.9917-14.9336V19.417M21.4129 4.4834V19.417M13.4461 4.4834V19.417" />
                            </svg>
                        </div>

                        <h2 class="text-2xl font-semibold mt-2">
                            {{ $currency }}{{ number_format($totalWallet, 2) }}
                        </h2>

                        <div class="mt-5 text-xs space-y-6">
                            <div>
                                <p>Wallet Balance: {{ $currency }}{{ number_format($totalWallet, 2) }}</p>
                            </div>
                            <div>
                                <p class="mb-2">Payouts: {{ $currency }}{{ number_format(($totalcommission ?? 0) - ($withdrawal ?? 0), 2) }}</p>
                                <span class="text-xs text-blue-500 underline cursor-pointer leading-relaxed">view</span>
                            </div>
                        </div>

                        <div class=" mt-7 mb-3">
                            <button class="bg-white text-gray-800 px-5 py-1 text-xs rounded-full font-medium">
                                Withdraw Request
                            </button>
                        </div>
                    </div>
                </div>


                    {{-- Small Cards --}}
                    <div class=" space-y-3 mt-5">

                        {{-- Total Commission --}}
                        <div class="p-2 bg-white border border-gray-200 rounded-full items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 flex justify-between">
                            <div class="flex items-center gap-4">
                                <div class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-1">
                                    <svg class="w-8 h-8 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.6 16.733c.234.269.548.456.895.534a1.4 1.4 0 0 0 1.75-.762c.172-.615-.446-1.287-1.242-1.481-.796-.194-1.41-.861-1.241-1.481a1.4 1.4 0 0 1 1.75-.762c.343.077.654.26.888.524m-1.358 4.017v.617m0-5.939v.725M4 15v4m3-6v6M6 8.5 10.5 5 14 7.5 18 4m0 0h-3.5M18 4v3m2 8a5 5 0 1 1-10 0 5 5 0 0 1 10 0Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-normal text-gray-800 dark:text-white">Total commission</h3>
                                    <span class="text-xs dark:text-gray-500">
                                        {{ $currency }}{{ number_format($totalcommission ?? 0, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Package Purchased --}}
                        <div class="p-2 bg-white border border-gray-200 rounded-full items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 flex justify-between">
                            <div class="flex items-center gap-4">
                                <div class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-1">
                                    <svg class="w-8 h-8 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-normal text-gray-800 dark:text-white">Package Purchased</h3>
                                    <span class="text-xs dark:text-gray-500">
                                        {{ $currency }}{{ number_format($packagePurchased, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- New Enrollment (TODAY) --}}
                        <div class="p-2 bg-white border border-gray-200 rounded-full items-center shadow-lg dark:border-gray-700 dark:bg-gray-900 flex justify-between">
                            <div class="flex items-center gap-4">
                                <div class="ring-2 ring-gray-700 dark:ring-blue-500 rounded-full p-1">
                                    <svg class="w-8 h-8 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-normal text-gray-800 dark:text-white">New Enrollment</h3>
                                    <span class="text-xs dark:text-gray-500">{{ $todayEnrollments }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Sales Section -->
                <div class="space-y-6">

                    {{-- Total Downlines --}}
                    <div class="bg-white overflow-hidden border shadow-lg border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                        <div class="items-center justify-between flex">
                            <div class="space-y-2">
                                <h2 class="text-xs text-gray-800 font-medium dark:text-white">Total Downlines</h2>
                                <p class="text-xs text-gray-700 dark:text-gray-500">{{ $totalDownlines }}</p>
                                <p class="text-xs text-gray-500 font-normal">
                                    <span class="{{ $downlineChange >= 0 ? 'text-blue-500' : 'text-red-500' }}">
                                        {{ abs($downlineChange) }}%
                                    </span> since last month
                                </p>
                            </div>
                            <div class="rounded-full p-1 ring-2 ring-gray-700 dark:ring-blue-500">
                                <svg class="w-10 h-10 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Personal Details (PV) --}}
                    <div class="bg-white overflow-hidden border shadow-lg border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                        <div class="items-center justify-between flex">
                            <div class="space-y-2">
                                <h2 class="text-xs text-gray-800 font-medium dark:text-white">Personal Details</h2>
                                <p class="text-xs text-gray-700 dark:text-gray-500">{{ $currency }}{{ number_format($personalPV, 2) }}</p>
                                <p class="text-xs text-gray-500 font-normal">
                                    <span class="{{ $personalChange >= 0 ? 'text-blue-500' : 'text-red-500' }}">
                                        {{ abs($personalChange) }}%
                                    </span> since last month
                                </p>
                            </div>
                            <div class="rounded-full p-1 ring-2 ring-gray-700 dark:ring-blue-500">
                                <svg class="w-10 h-10 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Sales --}}
                    <div class="bg-white overflow-hidden border shadow-lg border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                        <div class="items-center justify-between flex">
                            <div class="space-y-2">
                                <h2 class="text-xs text-gray-800 font-medium dark:text-white">Sales</h2>
                                <h2 class="text-xs text-gray-800 font-sm dark:text-gray-300">Personal Sales:</h2>
                                <p class="text-xs text-gray-700 dark:text-gray-500">
                                    {{ $currency }}{{ number_format($totalcommission, 2) }}
                                </p>
                                <p class="text-xs text-blue-800 dark:text-gray-500">
                                    {{ $currency }}{{ number_format($downlineSales, 2) }}
                                </p>
                                <p class="text-xs text-gray-600 font-normal">Downline sales</p>
                            </div>
                            <div class="rounded-full p-1 ring-2 ring-gray-700 dark:ring-blue-500">
                                <svg class="w-10 h-10 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4.5V19a1 1 0 0 0 1 1h15M7 14l4-4 4 4 5-5m0 0h-3.207M20 9v3.207" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Group Downline --}}
                    <div class="bg-white overflow-hidden border shadow-lg border-gray-200 rounded-xl p-3 dark:border-gray-800 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <div class="space-y-3">
                                <h2 class="text-xs text-gray-800 font-medium dark:text-white">Group Downline</h2>
                                <div class="flex items-center gap-10">
                                    <div>
                                        <h2 class="text-xs text-gray-700 font-sm dark:text-gray-300">Total Downlines:</h2>
                                        <p class="text-xs text-gray-600 dark:text-gray-500 mt-2">{{ $totalGroupDownlines }}</p>
                                    </div>
                                    <div>
                                        <h2 class="text-xs text-gray-700 font-sm dark:text-gray-300">Paid Members:</h2>
                                        <p class="text-xs text-gray-600 dark:text-gray-500 mt-2">{{ $paidMembersInGroup }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="rounded-full p-1 ring-2 ring-gray-700 dark:ring-blue-500 md:hidden">
                                <svg class="w-10 h-10 text-gray-800 dark:text-blue-500" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M16 19h4a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-2m-2.236-4a3 3 0 1 0 0-4M3 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

<div class="rounded-2xl h-fit border border-gray-200 shadow-lg bg-white dark:border-gray-800 dark:bg-gray-900">
    <div class="items-center justify-center p-3">
        <div class="mt-4 justify-center mb-4">
            <h2 class="text-center text-sm font-medium text-gray-800 dark:text-white">My Rank</h2>
        </div>

        <!-- Tabs -->
        <div class="flex justify-center gap-3 mb-4 text-xs mt-10">
            <button class="tab-btn px-2 py-1 rounded-2xl bg-blue-500 text-white" data-tab="current">Current Rank</button>
            <button class="tab-btn px-2 py-1 rounded-2xl bg-gray-300 text-gray-700" data-tab="last">Last Rank</button>
            <button class="tab-btn px-2 py-1 rounded-2xl bg-gray-300 text-gray-700" data-tab="history">Rank History</button>
        </div>

        <!-- Tab Contents -->
        <div class="tab-contents relative mt-8">

            <!-- Current Rank Slider -->
            <div class="tab-content" data-content="current">
                <div class="relative overflow-hidden h-52 text-center">
                    <div id="rank-cards" class="flex transition-transform duration-500">
                        @forelse($userRanks as $rank)
                            <div class="min-w-full h-52 flex flex-col justify-center items-center bg-white dark:bg-gray-900 p-4">
                                <svg width="150" height="80" viewBox="0 0 200 100">
                                    <path d="M10,100 A90,90 0 0,1 190,100" stroke="#E5E7EB" stroke-width="11" fill="none" />
                                    <path class="progress-arc"
                                          d="M10,100 A90,90 0 0,1 190,100"
                                          stroke="{{ $rank['rank_color'] }}"
                                          stroke-width="12" fill="none"
                                          stroke-dasharray="283"
                                          stroke-dashoffset="283"
                                          stroke-linecap="round"
                                          data-target="{{ $rank['progress'] }}" />
                                </svg>
                                <span class="progress-text text-xs font-normal mt-2" style="color: {{ $rank['rank_color'] }}">0%</span>
                                <h3 class="mt-2 text-xs font-normal text-gray-700 dark:text-gray-300">{{ $rank['rank_title'] }}</h3>

                                <div class="mt-5">
                                    <button onclick="openRankModal({{ json_encode($rank['conditions'], JSON_HEX_QUOT | JSON_HEX_APOS | JSON_HEX_AMP) }}, '{{ addslashes($rank['rank_title']) }}')"
                                            class="mx-auto text-xs px-3 py-1 bg-gray-800 hover:bg-gray-900 text-white dark:bg-blue-500 dark:hover:bg-blue-600 rounded-2xl">
                                        View Rank Requirement
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="min-w-full h-52 flex flex-col justify-center items-center">
                                <p class="text-gray-500 text-xs">No ranks available</p>
                            </div>
                        @endforelse
                    </div>

                    <button id="prev-btn" class="absolute left-0 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-500 dark:text-white" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="next-btn" class="absolute right-0 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-500 dark:text-white" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

        <!-- Last Rank -->
<!-- Last Rank -->
<div class="tab-content hidden" data-content="last">
    <div class="p-2 text-center text-gray-700 dark:text-gray-300">
        <div>
            <table class="w-full text-xs text-gray-500">
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
                                {{ $rank['rank_title'] }}
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

                <!-- Rank History -->
                <div class="tab-content hidden" data-content="history">
                    <div class="p-2">
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
                                                {{ $rank['rank_title'] }}
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

<!-- Modal -->
<div id="rankModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 h-96 overflow-y-auto">
        <h3 id="modalTitle" class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4"></h3>
        <div id="modalConditions"></div>
        <button onclick="document.getElementById('rankModal').classList.add('hidden')" class="mt-4 px-4 py-2 bg-gray-800 hover:bg-gray-900 text-xs dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded">Close</button>
    </div>
</div>



            </div>
        </div>

        <!-- 2nd Row - Order Stats + Member Stats -->
        <div class="rounded-2xl bg-gray-100 border border-gray-200 p-4 dark:bg-gray-900 dark:border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-2">

                {{-- 1st Col: Order Chart --}}
                <div class="bg-white dark:bg-gray-800 p-6 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                Order Statistics
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Total number of orders <span id="total-orders">0</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 mt-4 mb-6">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-200"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Delivered</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Orders</span>
                        </div>
                    </div>

                    <div>
                        <canvas id="orderChart" class="h-64"></canvas>
                    </div>
                </div>

                {{-- 3rd Col: Member Stats --}}
                <div class="bg-white p-6 border border-gray-200 rounded-xl shadow-sm
                            dark:bg-gray-900 dark:border-gray-700">

                    <h3 class="text-lg font-semibold text-gray-800 mb-5
                            dark:text-white">
                        Member Stats
                    </h3>

                    <div class="grid grid-cols-2 gap-4">

                        <!-- PV Card -->
                        <div class="p-4 bg-white rounded-lg border border-gray-200 cursor-pointer
                                    hover:shadow-md transition flex justify-between items-center
                                    dark:bg-gray-800 dark:border-gray-700"
                            onclick="showBlockModal('pvStatsModal','pvStatsTable','getpvstatsdetails')">
                            <div>
                                <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Purchase volume</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1 dark:text-gray-100"
                                id="pv-value">0</p>
                            </div>
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                            </svg>
                        </div>

                        <!-- GPV Card -->
                        <div class="p-4 bg-white rounded-lg border border-gray-200 cursor-pointer
                                    hover:shadow-md transition flex justify-between items-center
                                    dark:bg-gray-800 dark:border-gray-700"
                            onclick="showBlockModal('gpvStatsModal','gpvStatsTable','getgpvstatsdetails')">
                            <div>
                                <p class="text-sm font-medium text-purple-700 dark:text-purple-400">Gross purchase volume</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1 dark:text-gray-100"
                                id="gpv-value">0</p>
                            </div>
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.5 2a8.5 8.5 0 100 17 8.5 8.5 0 000-17zM11 6.025V13h6.975a7.04 7.04 0 01-.491 1.978l-.074.005a1 1 0 01-.934.998H11a1 1 0 01-1-1V6.025a1 1 0 011.065-.998z"/>
                            </svg>
                        </div>

                        <!-- Active Members Card -->
                        <div class="p-4 bg-white rounded-lg border border-gray-200 cursor-pointer
                                    hover:shadow-md transition flex justify-between items-center
                                    dark:bg-gray-800 dark:border-gray-700"
                            onclick="showBlockModal('activeMemberStatsModal','activeMemberStatsTable','getactivememberstatsdetails')">
                            <div>
                                <p class="text-sm font-medium text-green-700 dark:text-green-400">Active Members</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1 dark:text-gray-100"
                                id="active-members">0</p>
                            </div>
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zm-2 9a4 4 0 00-4 4v1a2 2 0 002 2h8a2 2 0 002-2v-1a4 4 0 00-4-4H6zm7.25-2.095a5.973 5.973 0 00-.75-2.906 4 4 0 110 5.811c.478-.86.75-1.85.75-2.905zM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 00-1.528-4H18a4 4 0 014 4v1a2 2 0 01-2 2h-4.535z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                        <!-- Paid Accounts Card -->
                        <div class="p-4 bg-white rounded-lg border border-gray-200 cursor-pointer
                                    hover:shadow-md transition flex justify-between items-center
                                    dark:bg-gray-800 dark:border-gray-700"
                            onclick="showBlockModal('paidAccountStatsModal','paidAccountStatsTable','getpaidaccountstatsdetails')">
                            <div>
                                <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Paid Accounts</p>
                                <p class="text-2xl font-bold text-gray-900 mt-1 dark:text-gray-100"
                                id="paid-members">0</p>
                            </div>
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 7V2.221a2 2 0 00-.5.365L4.586 6.5a2 2 0 00-.365.5H9z"/>
                                <path fill-rule="evenodd" d="M11 7V2h7a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V9h5a2 2 0 002-2zm4.707 5.707a1 1 0 00-1.414-1.414L11 14.586l-1.293-1.293a1 1 0 10-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>

                    </div>

                    <button type="button"
                            class="mt-6 w-full bg-gray-800 hover:bg-gray-900 text-white font-medium
                                py-3 rounded-lg transition
                                dark:bg-blue-600 dark:hover:bg-blue-700">
                        View All Statistics
                    </button>
                </div>
            </div>
        </div>

        <!-- 3rd Row  -->
        <div
            class="rounded-2xl bg-gray-100 border border-gray-200 p-4 dark:bg-gray-900 dark:border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 p-2 gap-5">
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
    </div>
         <!-- 4th Row – Recent Members + Map  -->
        <div class="rounded-2xl bg-gray-100 border border-gray-200 p-4 dark:bg-gray-900 dark:border-gray-800">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-2">

                {{-- ==== 1st Column – Recent Downline Members ==== --}}
                <div class="col-span-2 overflow-hidden rounded-2xl border border-gray-200 bg-white
                            px-4 pt-4 pb-3 sm:px-6
                            dark:border-gray-800 dark:bg-gray-900">

                    <div class="flex flex-col gap-2 mb-4 sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Recent Downline Members
                        </h3>

                        {{-- ==== INLINE FILTERS ==== --}}
                        <div class="flex items-center justify-between gap-2">
                            <select id="filterStatusRecent"
                                    class="text-xs rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium
                                        text-gray-700 hover:bg-gray-100
                                        dark:border-gray-700 dark:bg-gray-800 dark:text-blue-400">
                                <option value="">All Status</option>
                                <option value="Paid">Paid</option>
                                <option value="Pending">Pending</option>
                            </select>

                            <select id="filterCountryRecent"
                                    class="text-xs rounded-lg border border-gray-300 bg-white px-4 py-2.5 font-medium
                                        text-gray-700 hover:bg-gray-100
                                        dark:border-gray-700 dark:bg-gray-800 dark:text-blue-400">
                                <option value="">All Countries</option>
                                @foreach($countryStats as $c)
                                    <option value="{{ $c->code }}">{{ strtoupper($c->code) }}</option>
                                @endforeach
                            </select>

                            <button onclick="openSeeAllModal()"
                                    class="text-xs shadow-xs rounded-lg border border-gray-300
                                        bg-white px-5 py-2.5 font-medium text-gray-700 hover:bg-gray-100
                                        dark:border-gray-700 dark:bg-gray-800 dark:text-blue-500 dark:hover:text-white">
                                See All ({{ $allMembers->count() }})
                            </button>
                        </div>
                    </div>

                    <div class="max-w-full overflow-x-auto custom-scrollbar">
                        <table class="min-w-full" id="recentTable">
                            <thead class="border-y border-gray-100 dark:border-gray-800">
                                <tr>
                                    <th class="px-6 py-3 whitespace-nowrap text-left">
                                        <p class="font-semibold text-xs text-gray-600 dark:text-gray-300">Member</p>
                                    </th>
                                    <th class="px-6 py-3 whitespace-nowrap text-left">
                                        <p class="font-medium text-xs text-gray-600 dark:text-gray-300">Package</p>
                                    </th>
                                    <th class="px-6 py-3 whitespace-nowrap text-left">
                                        <p class="font-medium text-xs text-gray-600 dark:text-gray-300">Paid</p>
                                    </th>
                                    <th class="px-6 py-3 whitespace-nowrap text-left">
                                        <p class="font-medium text-xs text-gray-600 dark:text-gray-300">Status</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="recentBody">
                                <!-- Dynamic rows will be injected here via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ==== 2nd Column – Customers Demographic (Map + List) ==== --}}
                <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900 sm:p-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-800 dark:text-white">
                            Customers Demographic
                        </h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Number of customers based on country
                        </p>
                    </div>

                    <div class="my-6 overflow-hidden rounded-2xl border border-gray-200 bg-gray-50
                                px-4 py-6 dark:border-gray-800 dark:bg-gray-800/50">
                        <div id="mapOne" class="mapOne map-btn -mx-4 -my-6 h-[212px] w-auto"></div>
                    </div>

                    <div class="space-y-5">
                        @foreach($listCountries as $c)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-6 overflow-hidden rounded">
                                        <img src="https://flagcdn.com/24x18/{{ strtolower($c->code) }}.png"
                                            alt="{{ $c->code }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-gray-800 dark:text-white/90">
                                            {{ strtoupper($c->code) }}
                                        </p>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400">
                                            {{ number_format($c->total) }} Customers
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 max-w-[140px] w-full">
                                    <div class="relative h-2 w-full max-w-[100px] rounded-sm bg-gray-200 dark:bg-gray-700">
                                        <div class="absolute inset-0 rounded-sm bg-blue-500 transition-all duration-300"
                                            style="width: {{ $c->percent }}%;">
                                        </div>
                                    </div>
                                    <p class="text-xs font-medium text-gray-800 dark:text-white/90">
                                        {{ $c->percent }}%
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ==== MODALS (Updated Dark Mode) ==== --}}
<div id="seeAllModal" class="hidden fixed inset-0 z-50 w-full h-auto overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
    <div class="relative p-4 w-full max-w-3xl top-24">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-900 dark:text-white border border-gray-200 dark:border-gray-800">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-neutral-200">
                <h3 class="text-xl font-semibold text-black dark:text-white">
                    All Downline Members ({{ $allMembers->count() }})
                </h3>
                <button onclick="closeSeeAllModal()" class="text-neutral-400 bg-transparent hover:bg-neutral-200 hover:text-black dark:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-neutral-600 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-3 mb-4 ml-4 mr-4 mt-4">
                <input type="text" id="searchDownline" placeholder="Search by name or username..."
                       class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm
                              dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">

                <select id="filterStatusAll"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm
                               dark:border-gray-700 dark:bg-gray-800 dark:text-blue-400">
                    <option value="">All Status</option>
                    <option value="Paid">Paid</option>
                    <option value="Pending">Pending</option>
                </select>

                <select id="filterCountryAll"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm
                               dark:border-gray-700 dark:bg-gray-800 dark:text-blue-400">
                    <option value="">All Countries</option>
                    @foreach($countryStats as $c)
                        <option value="{{ $c->code }}">{{ strtoupper($c->code) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-x-auto max-h-96">
                <table class="min-w-full">
                    <thead class="border-b border-gray-200 dark:border-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Member</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Package</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Paid</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Joined</th>
                        </tr>
                    </thead>
                    <tbody id="allDownlineBody" class="divide-y divide-gray-100 dark:divide-gray-800">
                        <!-- Filled via JS -->
                    </tbody>
                </table>
            </div>

            <div id="loadMoreBtn" class="mt-4 text-center mb-4">
                <button onclick="loadMoreDownlines()"
                        class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900
                               dark:bg-blue-500 dark:hover:bg-blue-600 text-xs">
                    Load More
                </button>
            </div>
        </div>
    </div>
</div>

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
                    t.classList.remove('bg-blue-500', 'text-white');
                    t.classList.add('bg-gray-300', 'text-gray-700');
                });
                tab.classList.add('bg-blue-500', 'text-white');
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
