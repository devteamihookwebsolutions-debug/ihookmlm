@php
    // Safely get icon with fallback
    $iconPath = $iconPath ?? null;
    $finalIcon = $iconPath && trim($iconPath) !== '' 
        ? $iconPath 
        : asset('assets/img/user-dashboard/rank-default.png');

    // Extra safety: if somehow still empty or broken
    if (!filter_var($finalIcon, FILTER_VALIDATE_URL) && !str_starts_with($finalIcon, '/')) {
        $finalIcon = asset('assets/img/user-dashboard/rank-default.png');
    }
@endphp

<div class="w-full h-64 flex flex-col items-center justify-center rounded-xl shadow-2xl relative overflow-hidden
    {{ $isCurrent ?? false ? 'ring-4 ring-yellow-400 ring-offset-4 ring-offset-gray-900' : '' }}">
    
    <div class="absolute inset-0 bg-gradient-to-br 
        {{ ($isCurrent ?? false) ? 'from-purple-600 to-pink-600' : 
           (($isAchieved ?? false) ? 'from-green-500 to-teal-500' : 'from-gray-400 to-gray-600') }} 
        opacity-90"></div>

    <div class="relative z-10 text-center text-white px-4">
        <h3 class="text-2xl font-bold drop-shadow-lg">
            {{ $rankName ?? 'Unnamed Rank' }}
        </h3>

        <div class="mt-4 flex justify-center">
            <img 
                src="{{ $finalIcon }}" 
                alt="{{ $rankName ?? 'Rank' }} Icon"
                class="w-16 h-16 rounded-full object-cover border-4 border-white shadow-2xl
                       {{ ($isCurrent ?? false) ? 'ring-4 ring-yellow-300' : '' }}"
                onerror="this.src='{{ asset('assets/img/user-dashboard/rank-default.png') }}'; this.onerror=null;"
            >
        </div>

        @if($isCurrent ?? false)
            <div class="mt-4 px-6 py-3 bg-white text-purple-700 rounded-full font-bold animate-pulse shadow-lg">
                CURRENT RANK
            </div>
        @elseif($isAchieved ?? false)
            <div class="mt-3">
                <span class="inline-block px-4 py-2 bg-white bg-opacity-30 rounded-full text-sm font-medium backdrop-blur-sm">
                    Achieved
                </span>
            </div>
        @else
            <div class="mt-3">
                <span class="text-xs opacity-70">Locked</span>
            </div>
        @endif
    </div>
</div>