<!-- Row 2 -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">

    <!-- Wallet Widget -->
    <div class="bg-black rounded-lg shadow p-6 bg-[url(/tailassets/img/card-bg.jpg)] bg-cover bg-top bg-no-repeat border dark:border-neutral-700">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg dark:text-white text-neutral-100 font-mono font-semibold">{{ __('My Wallet') }}</h3>
            <img src="/tailassets/img/Subtract.svg" alt="net" class="w-6">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- eWallet -->
            <div class="p-3 rounded-lg bg-white/10 backdrop-blur-[10px] md:col-span-8 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                <div class="wallet-de">
                    <h3 class="font-semibold uppercase text-white/70 font-mono mb-2">{{ __('Wallet Amount') }}</h3>
                    <p class="text-2xl uppercase text-neutral-100 font-mono font-bold">
                        {{ config('site_settings.site_currency') ?? '$' }}{{ number_format($ewallet ?? 0, 2) }}
                    </p>
                </div>
            </div>

            <!-- cWallet -->
            <div class="p-3 rounded-lg bg-white/10 backdrop-blur-[10px] md:col-span-6 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                <div class="wallet-de">
                    <h3 class="font-semibold uppercase text-white/70 font-mono mb-2">{{ __('USD Balance') }}</h3>
                    <p class="text-2xl uppercase text-neutral-100 font-mono font-bold">
                        {{ config('site_settings.site_currency') ?? '$' }}{{ number_format($cwallet ?? 0, 2) }}
                    </p>
                </div>
            </div>

            <!-- Payout -->
            <div class="p-3 rounded-lg bg-white/10 backdrop-blur-[10px] md:col-span-6 hover:-translate-y-2 transition-transform duration-300 ease-in-out">
                <div class="wallet-de">
                    <h3 class="font-semibold uppercase text-white/70 font-mono mb-2">{{ __('Payout') }}</h3>
                    <p class="text-2xl uppercase text-neutral-100 font-mono font-bold">
                        {{ config('site_settings.site_currency') ?? '$' }}{{ number_format($withdrawal ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center mt-5">
            <div class="flex flex-col">
                <h3 class="text-xs uppercase text-neutral-100 font-mono font-semibold mb-1">
                    {{ $member->members_firstname ?? '' }} {{ $member->members_lastname ?? '' }}
                </h3>
                @if(isset($member->rankachieveddate))
                    @php
                        $formattedDate = \Carbon\Carbon::parse($member->rankachieveddate)->format('m/y');
                    @endphp
                    <h5 class="text-xs uppercase text-white/60 font-mono font-semibold">
                        {{ __('created on') }} <span>{{ $formattedDate }}</span>
                    </h5>
                @endif
            </div>
            <img src="/tailassets/img/Chip.svg" alt="chip" class="w-10">
        </div>
    </div>
    <!-- End Wallet Widget -->

    <!-- Member Stats -->
    <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
        <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Member Stats') }}</h3>
        <ul class="list-none">

            <!-- PV -->
            <li class="mb-4">
                <div class="p-3 rounded-lg hover:-translate-y-2 transition-transform duration-300 ease-in-out cursor-pointer"
                     onclick="showBlockModal('pvStatsModal','pvStatsTable','getpvstats')">
                    <div class="flex justify-between items-center">
                        <div class="icon-desc flex flex-wrap items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                            <div class="dark:text-white">{{ __('Purchase Volume (PV)') }}</div>
                        </div>
                        <div class="data-show-number">
                            <p class="text-2xl font-bold dark:text-neutral-100">{{ number_format($pv ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </li>

            <!-- GPV -->
            <li class="mb-4">
                <div class="p-3 rounded-lg hover:-translate-y-2 transition-transform duration-300 ease-in-out cursor-pointer"
                     onclick="showBlockModal('gpvStatsModal','gpvStatsTable','getgpvstats')">
                    <div class="flex justify-between items-center">
                        <div class="icon-desc flex flex-wrap items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                            </svg>
                            <div class="dark:text-white">{{ __('Gross Purchase Volume (GPV)') }}</div>
                        </div>
                        <div class="data-show-number">
                            <p class="text-2xl font-bold dark:text-neutral-100">{{ number_format($gpv ?? 0, 2) }}</p>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Active Members -->
            <li class="mb-4">
                <div class="p-3 rounded-lg hover:-translate-y-2 transition-transform duration-300 ease-in-out cursor-pointer"
                     onclick="showBlockModal('activeMemberStatsModal','activeMemberStatsTable','getactivememberstats')">
                    <div class="flex justify-between items-center">
                        <div class="icon-desc flex flex-wrap items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                            <div class="dark:text-white">{{ __('Active Members') }}</div>
                        </div>
                        <div class="data-show-number">
                            <p class="text-2xl font-bold dark:text-neutral-100">{{ $active_members ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Paid Accounts -->
            <li>
                <div class="p-3 rounded-lg hover:-translate-y-2 transition-transform duration-300 ease-in-out cursor-pointer"
                     onclick="showBlockModal('paidAccountStatsModal','paidAccountStatsTable','getpaidaccountstats')">
                    <div class="flex justify-between items-center">
                        <div class="icon-desc flex flex-wrap items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6 dark:text-white">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                            </svg>
                            <div class="dark:text-white">{{ __('Paid Accounts') }}</div>
                        </div>
                        <div class="data-show-number">
                            <p class="text-2xl font-bold dark:text-neutral-100">{{ $paid_members ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <!-- End Member Stats -->

    <!-- Top Products -->
    <div class="bg-white rounded-lg shadow p-6 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white border border-neutral-200">
        <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Top Products') }}</h3>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @forelse($top_products ?? [] as $product)
                    <div class="swiper-slide">
                        <div class="text-center">
                            <div class="flex justify-center mb-3">
                                <img src="{{ $product['image'] }}" alt="{{ $product['order_item_name'] }}" class="w-28 h-28 object-cover rounded">
                            </div>
                            <h3 class="text-lg dark:text-white font-semibold line-clamp-2">{{ $product['order_item_name'] }}</h3>
                            <p class="text-black dark:text-white">
                                {{ config('site_settings.site_currency') ?? '$' }}{{ number_format($product['productprice'], 2) }}
                            </p>
                            <a href="{{ config('site_settings.woocommerce_path') }}/shop" target="_blank">
                                <button type="button"
                                    class="text-black dark:text-white bg-white hover:bg-neutral-100 focus:ring-4 focus:ring-neutral-100 font-medium rounded-full text-sm px-5 py-2.5 mt-3 dark:bg-neutral-900 dark:hover:bg-neutral-700">
                                    {{ __('Know More') }}
                                </button>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="text-center py-8">
                            <img src="/public/assets/img/no-products.svg" class="w-32 h-32 mx-auto mb-4" alt="No products">
                            <p class="text-neutral-500">{{ __('No products found') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
    <!-- End Top Products -->

    <!-- Top Earners -->
    <div class="bg-[url('/public/assets/img/banner-4.png')] bg-cover bg-top bg-no-repeat dark:bg-neutral-900 rounded-lg shadow p-6">
        <h3 class="text-lg dark:text-white font-semibold mb-5">{{ __('Top Earners') }}</h3>

        <ul class="list-none crm-top-deals mb-0">
            @forelse($top_earners ?? [] as $record)
                <li class="mb-4">
                    <div class="flex items-start flex-wrap">
                        <div class="me-2">
                            <span class="inline-flex items-center justify-center">
                                <img src="{{ env('CDNCLOUDEXTURL') }}/{{ $record->members_image ?? 'default-avatar.png' }}"
                                     alt="{{ $record->members_firstname }}"
                                     class="w-12 h-12 rounded-full object-cover">
                            </span>
                        </div>
                        <div class="flex-grow">
                            <p class="font-semibold mb-1 text-normal">
                                {{ $record->members_firstname }} {{ $record->members_lastname }}
                            </p>
                            <p class="text-neutral-400 text-xs mb-0">{{ $record->members_email }}</p>
                        </div>
                        <div class="font-semibold text-[0.9375rem]">
                            {{ config('site_settings.site_currency') ?? '$' }}{{ number_format($record->totalprice, 2) }}
                        </div>
                    </div>
                </li>
            @empty
                <div class="text-center py-8">
                    <img src="/public/assets/img/no-user.svg" class="w-32 h-32 mx-auto mb-4" alt="No earners">
                    <p class="text-neutral-500">{{ __('No earners found') }}</p>
                </div>
            @endforelse
        </ul>
    </div>
    <!-- End Top Earners -->

</div>
<!-- End Row 2 -->