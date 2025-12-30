@forelse($rows as $row)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $row->history_transaction_id }}</td>
    <td>{{ $row->formatted_amount }}</td>
    <td>{{ $row->history_description }}</td>
    <td>{{ $row->formatted_date }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center text-gray-500 py-4">No E-Wallet records.</td>
</tr>
@endforelse
