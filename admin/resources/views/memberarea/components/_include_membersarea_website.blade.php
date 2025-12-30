<div class="hidden" id="website" role="tabpanel"
    aria-labelledby="website-tab">
    <h3 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-3 md:mt-0 mt-8">
        {{ __('Replicating site') }}
    </h3>
    <div class="bg-white border dark:border-gray-800 dark:bg-gray-900 rounded-xl p-5">

        @if($block1details['replicated_url'] && $block1details['replicated_url'] != '#')
        <a aria-label="Replicated Site Link" href="{{ $block1details['replicated_url'] }}" target="_blank"
            rel="noopener" class="text-blue-500 hover:underline">
            {{ $block1details['replicated_url'] }}
        </a>
        @else
        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('No replicated site available') }}</span>
        @endif
    </div>
</div>