@forelse($orders as $index => $order)
    <tr class="border-b dark:border-neutral-700 hover:bg-gray-50 dark:hover:bg-neutral-800">
        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
            {{ \Carbon\Carbon::parse($order->created_on)->format('d M Y, h:i A') }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
            {{ $order->members_email ?? ($order->member->members_email ?? '—') }}
        </td>
        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
            {{ $order->order_currency ?? 'INR' }}
        </td>
        <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">
            {{ number_format($order->order_total, 2) }}
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center py-8 text-gray-500 dark:text-gray-300">
            {{ __('No personal purchases found') }}
        </td>
    </tr>
@endforelse