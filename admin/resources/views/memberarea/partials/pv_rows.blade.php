@forelse($rows as $row)
<tr>
    <td>{{ $row->formatted_date }}</td>
    <td>{{ $row->history_description }}</td>
    <td>{{ $row->formatted_amount }} PV</td>
</tr>
@empty
<tr><td colspan="3" class="text-center text-gray-500 py-4">No PV records.</td></tr>
@endforelse