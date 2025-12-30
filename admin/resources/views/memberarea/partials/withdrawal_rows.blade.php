@forelse($rows as $index => $row)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $row->formatted_amount }}</td>
    <td>{{ $row->account_id ?? '-' }}</td>
    <td>
        <span class="px-2 py-1 text-xs font-medium rounded-full
            @if($row->history_type == 'withdraw_pending') bg-yellow-100 text-yellow-800
            @elseif($row->history_type == 'withdrawal') bg-blue-100 text-blue-800
            @else bg-green-100 text-green-800 @endif">
            {{ $row->status }}
        </span>
    </td>
    <td>{{ $row->formatted_date }}</td>
</tr>
@empty
<tr><td colspan="5" class="text-center text-gray-500 py-4">No withdrawal requests.</td></tr>
@endforelse