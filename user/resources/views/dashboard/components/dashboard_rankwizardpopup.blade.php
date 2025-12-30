{{--  RANK REQUIREMENTS MODAL - FINAL VERSION  --}}
<div id="rankmodal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen bg-black/50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white rounded-xl shadow-2xl dark:bg-neutral-900 dark:text-white border border-neutral-200 dark:border-neutral-800">

            {{-- Header --}}
            <div class="flex items-center justify-between p-5 border-b dark:border-neutral-700 rounded-t-xl bg-gradient-to-r from-blue-500 to-purple-600 text-white">
                <h3 class="text-xl font-bold">
                    Requirements for <span class="text-yellow-300">{{ $nextRankName ?? 'Next Rank' }}</span>
                </h3>
                <button type="button" onclick="hideModal('rankmodal')"
                        class="text-white hover:bg-white/20 rounded-lg p-2 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-5">
                @php
                    $totalProgress = 0;
                    $count = 0;
                @endphp

                @forelse($rankrequirement['nextrankconditions'] ?? [] as $key => $required)
                    @php
                        $current = match((int)$key) {
                            1  => $rankrequirement['directreferral'] ?? 0,
                            2  => $rankrequirement['groupreferral'] ?? 0,
                            3  => $rankrequirement['noofsales'] ?? 0,
                            4  => $rankrequirement['noofprodctsold'] ?? 0,
                            5  => $rankrequirement['targetachieved'] ?? 0,
                            6  => $rankrequirement['levelcompletion'] ?? 0,
                            7  => $rankrequirement['totalPV'] ?? 0,
                            8  => $rankrequirement['totalGPV'] ?? 0,
                            9  => $rankrequirement['salestargetamount'] ?? 0,
                            10 => $rankrequirement['grouptargetamount'] ?? 0,
                            11 => $rankrequirement['onlinesalesPV'] ?? 0,
                            default => 0,
                        };

                        $progress = $required > 0 ? min(100, round(($current / $required) * 100)) : 0;
                        if ($progress > 0) {
                            $totalProgress += $progress;
                            $count++;
                        }

                        $labels = [
                            1 => 'Direct Referrals',
                            2 => 'Group Referrals',
                            3 => 'Number of Sales',
                            4 => 'Products Sold',
                            5 => 'Target Achieved',
                            6 => 'Level Completion',
                            7 => 'Personal PV',
                            8 => 'Group PV',
                            9 => 'Sales Target',
                            10 => 'Group Sales Target',
                            11 => 'Online Sales PV',
                        ];
                        $label = $labels[$key] ?? 'Unknown';
                    @endphp

                    <div class="group p-5 bg-gradient-to-br from-neutral-50 to-neutral-100 dark:from-neutral-800 dark:to-neutral-900 rounded-xl border border-neutral-300 dark:border-neutral-700 hover:shadow-lg transition-all duration-300">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-semibold text-neutral-800 dark:text-neutral-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                                {{ __($label) }}
                            </h4>
                            <span class="text-sm font-bold text-neutral-600 dark:text-neutral-400">
                                {{ $current }} / {{ $required }}
                            </span>
                        </div>

                        <div class="relative">
                            <div class="w-full bg-neutral-300 dark:bg-neutral-700 rounded-full h-4 overflow-hidden">
                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-full rounded-full transition-all duration-700 ease-out"
                                     style="width: {{ $progress }}%"></div>
                            </div>
                            <div class="absolute inset-0 flex justify-end items-center pr-3">
                                <span class="text-xs font-bold text-white drop-shadow-md">
                                    {{ $progress }}%
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <img src="/img/user-dashboard/no-data.svg" class="w-24 mx-auto mb-4 opacity-60" alt="No data">
                        <p class="text-neutral-500 dark:text-neutral-400">No requirements defined yet.</p>
                    </div>
                @endforelse

                @if($count > 0)
                    <div class="mt-8 p-6 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl text-white text-center shadow-xl">
                        <p class="text-lg font-medium opacity-90">Overall Progress</p>
                        <p class="text-5xl font-bold mt-2">
                            {{ round($totalProgress / $count) }}%
                        </p>
                        <p class="text-sm mt-2 opacity-80">Keep pushing! You're almost there!</p>
                    </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="flex justify-end p-5 border-t dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-800 rounded-b-xl">
                <button onclick="hideModal('rankmodal')"
                        class="px-8 py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-medium rounded-full hover:shadow-lg transform hover:scale-105 transition">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
