{{-- resources/views/user/dashboard/partials/wallet-card.blade.php --}}
@php
    $currency = Session::get('site_settings.site_currency', '$');
    $cWallet  = DashboardBlock1Overview::getWalletBalance(auth()->user()->members_id, 1);
    $eWallet  = DashboardBlock1Overview::getWalletBalance(auth()->user()->members_id, 2);
    $total    = $cWallet + $eWallet;

    $paidPayouts = DB::table(config('services.ihook.prefix').'_history_table AS h')
        ->join(config('services.ihook.prefix').'_history_type_table AS t', 'h.history_type', '=', 't.history_type_name')
        ->where('h.history_member_id', auth()->user()->members_id)
        ->whereIn('h.history_type', ['withdrawal','withdrawcompleted'])
        ->where('t.history_debit_type', 1)
        ->sum('h.history_amount');
@endphp

<div class="bg-[url('/img/profile-bg.jpg')] bg-center rounded-2xl text-white p-5 shadow-md">
    <div class="flex justify-between">
        <h2 class="text-xs">YOUR WALLET AMOUNT</h2>
        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                  d="M2.9917 4.9834V18.917M9.96265 4.9834V18.917M15.9378 4.9834V18.917m2.9875-13.9336V18.917"/>
            <path stroke="currentColor" stroke-linecap="round"
                  d="M5.47925 4.4834V19.417m1.9917-14.9336V19.417M21.4129 4.4834V19.417M13.4461 4.4834V19.417"/>
        </svg>
    </div>

    <h2 class="text-2xl font-semibold mt-1">{{ $currency }}{{ number_format($total, 2) }}</h2>

    <div class="mt-4 text-xs flex justify-between">
        <div>
            <p>Wallet Balance: {{ $currency }}{{ number_format($total, 2) }}</p>
        </div>
        <div>
            <p>Payouts: {{ $currency }}{{ number_format($paidPayouts, 2) }}</p>
            <span class="text-xs text-blue-400 underline cursor-pointer"
                  onclick="openWalletModal()">view</span>
        </div>
    </div>

    <div class="flex justify-between mt-4">
        <button class="bg-white text-gray-800 px-5 py-1 text-sm rounded-full font-medium">
            Withdraw Request
        </button>
    </div>
</div>