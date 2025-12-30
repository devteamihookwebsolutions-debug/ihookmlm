@forelse($rows as $row)
<tr>
    <td>{{ $row->member?->members_username ?? 'N/A' }}</td>
    <td>{{ $row->formatted_amount }}</td>
    <td>{{ $row->formatted_date }}</td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center text-gray-500 py-4">No fund transfers.</td>
</tr>
@endforelse