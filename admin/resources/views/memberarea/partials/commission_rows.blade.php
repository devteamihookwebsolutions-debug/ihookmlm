@forelse($commissions as $i => $c)
<tr class="border-b dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800">
    <td class="px-4 py-2 text-sm">{{ $i + 1 }}</td>
    <td class="px-4 py-2 text-sm font-medium">${{ number_format($c->history_amount, 2) }}</td>
    <td class="px-4 py-2 text-sm">{!! nl2br(e($c->history_description)) !!}</td>
    <td class="px-4 py-2 text-sm">{{ \Carbon\Carbon::parse($c->history_datetime)->format('d M Y') }}</td>
    <td class="px-4 py-2 text-sm">
        @if($c->history_transaction_id)
          <a href="{{ route('commission.pdf', $c->history_id) }}" target="_blank"
            class="text-blue-600 hover:underline text-xs flex items-center gap-1">
           <svg class="w-6 h-6 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
            </svg>
            </a>
        @else
            —
        @endif
    </td>
</tr>
@empty
<tr><td colspan="5" class="text-center py-8 text-gray-500 text-sm">No records</td></tr>
@endforelse