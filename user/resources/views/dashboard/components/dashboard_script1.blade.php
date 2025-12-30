{{-- resources/views/dashboard/components/dashboard_block1.blade.php --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">

    {{-- Column 1: My Profile --}}
    <div class="flex flex-col gap-4">
        <div class="bg-white dark:bg-neutral-900 h-full rounded-lg shadow p-6 flex flex-col justify-between bg-center bg-no-repeat bg-cover border border-neutral-200 dark:border-neutral-700 bg-[url('/assets/img/user-dashboard/profile-bg.png')]">
            <div>
                <h3 class="text-lg dark:text-white font-semibold text-center mb-2">{{ __('My Profile') }}</h3>
            </div>
            <div class="relative mx-auto rounded-full">
                <span class="absolute right-0 m-3 h-3 w-3 rounded-full bg-green-500 ring-2 ring-green-300 ring-offset-2"></span>
                <img class="mx-auto h-auto w-24 rounded-full mb-2"
                     src="{{ $block2details['membersimage'] ?? '/assets/img/avatar.png' }}"
                     alt="Profile">
                <h4 class="text-center text-md font-semibold text-black dark:text-white">
                    {{ $block2details['members_firstname'] ?? '' }} {{ $block2details['members_lastname'] ?? '' }}
                </h4>
                <h5 class="text-xs text-center text-black dark:text-white">{{ __('Distributor') }}</h5>
            </div>
            <ul class="mt-3 divide-y divide-neutral-200 dark:divide-neutral-600 rounded bg-white dark:bg-neutral-900 dark:border-neutral-500 py-2 px-3 text-black shadow-sm hover:text-black hover:shadow">
                <li class="flex items-center py-3 text-sm">
                    <span class="dark:text-white">{{ __('Rank') }}</span>
                    <span class="ml-auto">
                        <span class="rounded-full bg-yellow-200 py-1 px-2 text-xs font-medium text-yellow-700">
                            {{ $block2details['rankname'] ?? 'N/A' }}
                        </span>
                    </span>
                </li>
                <li class="flex items-center py-3 text-sm">
                    <span class="dark:text-white">{{ __('DOJ') }}</span>
                    <span class="ml-auto dark:text-white">{{ $block2details['rankachieveddate'] ?? 'N/A' }}</span>
                </li>
                <li class="flex items-center py-3 text-sm">
                    <span class="dark:text-white">{{ __('Sponsor ID') }}</span>
                    <span class="ml-auto dark:text-white">{{ $block2details['sponsor_fullname'] ?? 'N/A' }}</span>
                </li>
                <li class="flex items-center py-3 text-sm">
                    <span class="dark:text-white">{{ __('Package Details') }}</span>
                    <span class="ml-auto dark:text-white flex items-center gap-1">
                        {{ $block2details['package_name'] ?? 'N/A' }}
                        <a href="/user/package/upgrade/1/0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25-3-3m0 0-3 3m3-3v7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </a>
                    </span>
                </li>
            </ul>
        </div>
    </div>

    {{-- Column 2: Banner + Widgets --}}
    <div class="flex flex-col gap-4">
        <div class="bg-white dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 rounded-lg h-full shadow p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="left-side">
                    <h3 class="text-lg dark:text-white font-semibold mb-2">{{ __('Boost Up Your Sale') }}</h3>
                    <p class="text-sm dark:text-white">{{ __('by upgrading your account you can increase your sale by 30% more.') }}</p>
                    <button type="button" onclick="window.location.href='/user/package/upgrade/1/0';"
                            class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-lime-200 dark:focus:ring-teal-700 font-medium rounded-full text-sm px-3 py-1.5 text-center mt-2">
                        {{ __('Upgrade Now') }}
                    </button>
                </div>
                <div class="right-side flex justify-end">
                    <img src="/assets/img/user-dashboard/happy-cute-robot.png" alt="banner" class="w-24 h-32 transition-transform duration-300 transform hover:scale-110">
                </div>
            </div>
        </div>

        <div class="bg-white dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 rounded-lg h-full shadow p-6 cursor-pointer"
             onclick="showBlockModal('totalCommisionModal','totalCommisionTable','gettotalcommisions')">
            <h3 class="text-lg dark:text-white font-semibold mb-2">{{ __('Total Commission') }}</h3>
            <div class="grid md:grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-3">
                <div class="widget-data">
                    <p class="text-2xl font-bold dark:text-neutral-100">
                        {{ $currency }}{{ number_format($totalcommission['total_amount'] ?? 0, 2) }}
                    </p>
                    <p class="{{ ($totalcommission['percentage_change'] ?? 0) < 0 ? 'text-red-500' : 'text-green-500' }} text-sm mt-1">
                        {{ $totalcommission['percentage_change'] ?? 0 }}% {{ __('this week') }}
                    </p>
                </div>
                <div id="sparkline-chart" class="w-full flex lg:justify-end sm:justify-start"></div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 cursor-pointer"
             onclick="showBlockModal('ordersModal','ordersTable','getordersdetails')">
            <h3 class="text-lg dark:text-white font-semibold mb-2">{{ __('Orders') }}</h3>
            <div class="grid md:grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-3">
                <div class="widget-data">
                    <p class="text-2xl font-bold dark:text-neutral-100">
                        {{ $totalorders['total_orders_all_time'] ?? '0' }}
                    </p>
                    <p class="{{ ($totalorders['percentage_change'] ?? 0) < 0 ? 'text-red-500' : 'text-green-500' }} text-sm mt-1">
                        {{ $totalorders['percentage_change'] ?? 0 }}% {{ __('this week') }}
                    </p>
                </div>
                <div id="sparkline-chart1" class="w-full flex lg:justify-end sm:justify-start"></div>
            </div>
        </div>
    </div>

    {{-- ==== COLUMN 3 : REPLICATE LINK + PACKAGE + DOWNLINES ==== --}}
    <div class="space-y-4">
        {{-- Replicate & Share --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ __('Link & Share') }}</h3>
                <div class="flex gap-2">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $block1details['replicated_url'] ?? '' }}" target="_blank"
                       class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <img src="/assets/img/user-dashboard/share-icons/fb.svg" alt="FB" class="w-5 h-5">
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ $block1details['replicated_url'] ?? '' }}&text={{ $siteName ?? 'MLM Site' }}" target="_blank"
                       class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <img src="/assets/img/user-dashboard/share-icons/x.svg" alt="X" class="w-5 h-5">
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url={{ $block1details['replicated_url'] ?? '' }}&title={{ $siteName ?? 'MLM Site' }}" target="_blank"
                       class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <img src="/assets/img/user-dashboard/share-icons/in.svg" alt="LinkedIn" class="w-5 h-5">
                    </a>
                    <a href="mailto:?subject={{ $siteName ?? 'MLM Site' }}&body=Check this out: {{ $block1details['replicated_url'] ?? '' }}"
                       class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <img src="/assets/img/user-dashboard/share-icons/mail.svg" alt="Mail" class="w-5 h-5">
                    </a>
                    <a href="https://wa.me/?text={{ urlencode('Check this out: ' . ($block1details['replicated_url'] ?? '')) }}" target="_blank"
                       class="p-2 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        <img src="/assets/img/user-dashboard/whatapp.png" alt="WhatsApp" class="w-5 h-5">
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <input type="text" id="website-url" readonly
                       value="{{ $block1details['replicated_url'] ?? '' }}"
                       class="flex-1 px-3 py-2 text-sm bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-l-lg text-gray-700 dark:text-gray-300">
                <button onclick="copyToClipboard('website-url','default-icon-replicate','success-icon-replicate')"
                        class="px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-l-0 border-gray-300 dark:border-gray-600 rounded-r-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    <span id="default-icon-replicate">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span id="success-icon-replicate" class="hidden text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 16 12">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        {{-- Package Purchased --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-5 cursor-pointer shadow-sm"
             onclick="showBlockModal('packagePurchasedModal','packagePurchasedTable','getpackagepurchased')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Package Purchased') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                        {{ $currency }}{{ number_format($totalPackagePurchased['total_amount'] ?? 0, 2) }}
                    </p>
                    <p class="text-sm mt-1 {{ ($totalPackagePurchased['percentage_change'] ?? 0) < 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $totalPackagePurchased['percentage_change'] ?? 0 }}% {{ __('this week') }}
                    </p>
                </div>
                <div id="sparkline-chart2" class="w-24 h-12"></div>
            </div>
        </div>

        {{-- Direct Downlines --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-5 cursor-pointer shadow-sm"
             onclick="showBlockModal('directDownlinesModal','directDownlinesTable','getdirectdownlinesdetails')">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Direct Downlines') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">
                        {{ $directdownlines['total_direct_all_time'] ?? '0' }}
                    </p>
                    <p class="text-sm mt-1 {{ ($directdownlines['percentage_change'] ?? 0) < 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $directdownlines['percentage_change'] ?? 0 }}% {{ __('this week') }}
                    </p>
                </div>
                <div id="sparkline-chart3" class="w-24 h-12"></div>
            </div>
        </div>
    </div>

    {{-- Column 4: My Rank — FULLY FIXED --}}
    <div class="flex flex-col gap-4">
        <div class="bg-white dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200 rounded-lg h-full shadow p-6">
            <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('My Rank') }}</h3>

            {{-- Tabs --}}
            <div class="flex justify-center mt-10">
                <ul class="inline-flex bg-neutral-100 p-1 rounded-full space-x-2 text-xs font-medium text-center text-black"
                    id="rounded-tab" role="tablist">
                    <li>
                        <button 
                            type="button" 
                            class="tab-button px-5 py-2.5 rounded-full bg-white dark:bg-neutral-700 text-blue-600" 
                            data-tab="current" 
                            onclick="loadRankTab('current')">
                            {{ __('Current Rank') }}
                        </button>
                    </li>                    
                    <li><button type="button" class="tab-button px-5 py-2.5 rounded-full bg-white dark:bg-neutral-700 text-blue-600" data-tab="history" onclick="loadRankTab('history')">{{ __('Rank History') }}</button></li>
                    <li><button type="button" class="tab-button px-5 py-2.5 rounded-full bg-white dark:bg-neutral-700 text-blue-600" data-tab="details" onclick="loadRankTab('details')">{{ __('Rank Details') }}</button></li>
                </ul>
            </div>

            <div id="tab-content" class="mt-6">
                {{-- Current Rank --}}
                <div data-tab="current" class="block">
                    <div class="relative overflow-hidden rounded-lg">
                        <button class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-white dark:bg-neutral-800 p-2 rounded-full shadow-lg hover:scale-110 transition slide-prev">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-white dark:bg-neutral-800 p-2 rounded-full shadow-lg hover:scale-110 transition slide-next">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <div id="rank-slider" class="flex transition-transform duration-500" style="width: 300%">
                            {!! $rankwiz['chart'] ?? '<div class="w-full flex-center h-64 text-gray-400">No rank chart</div>' !!}
                        </div>
                    </div>
                </div>

               {{-- Rank History --}}
                <div data-tab="history" class="hidden">
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($rankrequirement['rankhistory'] ?? [] as $h)
                            @php
                                // Correct field names from your getRankHistory() function
                                $icon = $h->icon ?? '/assets/img/user-dashboard/rank-default.png';
                                $name = $h->name ?? 'Unknown Rank';
                                $date = $h->date ?? 'N/A';
                                
                                // Optional: fallback image if file doesn't exist
                                $img = $icon && file_exists(public_path($icon)) 
                                    ? $icon 
                                    : '/assets/img/user-dashboard/rank-default.png';
                            @endphp

                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-neutral-800 rounded-xl mb-3 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $img }}" 
                                        alt="{{ $name }}" 
                                        class="w-12 h-12 rounded-full ring-2 ring-white shadow-lg object-cover">
                                    <div>
                                        <p class="font-bold text-black dark:text-white">{{ $name }}</p>
                                        <p class="text-sm text-gray-500">{{ $date }}</p>
                                    </div>
                                </div>
                                <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <img src="/assets/img/user-dashboard/no-rank-history.svg" class="w-24 mx-auto mb-4 opacity-50" alt="No history">
                                <p class="text-gray-500 dark:text-gray-400">No rank history yet. Keep growing!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Rank Details --}}
                <div data-tab="details" class="hidden">
                    <div class="space-y-3">
                        @forelse($rankrequirement['allnextranks'] ?? [] as $rank)
                            @php
                                $id = $rank['rank_id'] ?? $rank->rank_id ?? 0;
                                $name = $rank['rank_value'] ?? $rank->rank_value ?? 'Next Rank';
                            @endphp
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-neutral-800 dark:to-neutral-700 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex-center text-white font-bold text-lg">
                                        {{ substr($name, 0, 2) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-lg">{{ $name }}</h4>
                                        <p class="text-xs text-gray-600">Click to view requirements</p>
                                    </div>
                                </div>
                                <button onclick="openRankModal({{ $id }}, '{{ addslashes($name) }}')"
                                        class="p-3 bg-purple-600 text-white rounded-xl hover:scale-110 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <p class="text-center py-12 text-gray-500">No upcoming ranks</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Tab Switch
    document.querySelectorAll('.tab-button').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('bg-white', 'dark:bg-neutral-700', 'text-blue-600'));
            document.querySelectorAll('[data-tab]').forEach(c => c.classList.add('hidden'));
            btn.classList.add('bg-white', 'dark:bg-neutral-700', 'text-blue-600');
            document.querySelector(`[data-tab="${btn.dataset.tab}"]`).classList.remove('hidden');
        });
    });

    // Rank Slider
    let slideIndex = 0;
    const slider = document.getElementById('rank-slider');
    const totalSlides = slider.children.length;

    document.querySelectorAll('.slide-next').forEach(btn => {
        btn.addEventListener('click', () => {
            slideIndex = (slideIndex + 1) % totalSlides;
            slider.style.transform = `translateX(-${slideIndex * 33.333}%)`;
        });
    });

    document.querySelectorAll('.slide-prev').forEach(btn => {
        btn.addEventListener('click', () => {
            slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
            slider.style.transform = `translateX(-${slideIndex * 33.333}%)`;
        });
    });
});

// Copy to Clipboard
function copyToClipboard(inputId, defaultId, successId) {
    const input = document.getElementById(inputId);
    input.disabled = false;
    input.select(); 
    document.execCommand('copy');
    input.disabled = true;
    document.getElementById(defaultId).classList.add('hidden');
    document.getElementById(successId).classList.remove('hidden');
    setTimeout(() => {
        document.getElementById(defaultId).classList.remove('hidden');
        document.getElementById(successId).classList.add('hidden');
    }, 2000);
}

// Open Rank Modal
function openRankModal(rankId, rankName) {
    const modal = document.getElementById('rankmodal');
    const body = modal.querySelector('.modal-body');
    document.getElementById('modal-rank-name').textContent = rankName;

    body.innerHTML = '<div class="text-center py-16"><div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-purple-500 border-t-transparent"></div><p class="mt-4">Loading requirements...</p></div>';
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    fetch(`/user/dashboard/getrankdetailsrequirements/${rankId}`)
        .then(r => r.text())
        .then(html => body.innerHTML = html)
        .catch(() => body.innerHTML = '<p class="text-red-500 text-center">Failed to load data.</p>');
}

function hideModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
}
</script>