@forelse($rows as $row)
<tr>
    <td>{{ $row->formatted_date }}</td>
    <td>{{ $row->history_description }}</td>
    <td>{{ $row->formatted_amount }}</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-gray-500 py-4">No transactions found.</td></tr>
@endforelse