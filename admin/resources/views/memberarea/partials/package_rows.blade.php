@forelse($packages as $p)
<tr class="border-b dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800">
    <td class="px-4 py-2 text-sm">{{ $p->matrix->matrix_name ?? '—' }}</td>
    <td class="px-4 py-2 text-sm">{{ $p->paymenthistory_date?->format('d M Y') }}</td>
    <td class="px-4 py-2 text-sm">{{ $p->package->package_name ?? '—' }}</td>
    <td class="px-4 py-2 text-sm font-medium">${{ number_format($p->paymenthistory_amount, 2) }}</td>
    <td class="px-4 py-2 text-sm">
        <span class="px-2 py-1 text-xs rounded-full {{ $p->paymenthistory_status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            {{ $p->paymenthistory_status == 1 ? 'Yes' : 'No' }}
        </span>
    </td>
    <td class="px-4 py-2 text-sm">
        @if($p->paymenthistory_trans_id)
            <a href="{{ route('package.pdf', $p->paymenthistory_id) }}" target="_blank"
               class="text-blue-600 hover:underline text-xs">
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
<tr><td colspan="6" class="text-center py-8 text-gray-500 text-sm">No package records</td></tr>
@endforelse