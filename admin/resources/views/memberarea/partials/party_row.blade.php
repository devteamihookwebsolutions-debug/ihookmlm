<tr>
    <td>{{ $sno }}</td>
    <td>{{ $row->setup_party_id }}</td>
    <td>{{ $row->setup_name }}</td>   {{-- key --}}
    <td>{{ $row->setup_value }}</td> {{-- value --}}
    <td>{{ $row->created_at ?? $row->id }}</td>
    <td>
        @if($row->status == 1)
            <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Active</span>
        @else
            <span class="px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-full">Inactive</span>
        @endif
    </td>
</tr>