<tr>
    <th scope="row">{{ __('Not Paid') }}</th>
    <td>{{ $currency }}{{ number_format($unpaid, 2) }}</td>
</tr>
<tr>
    <th scope="row">{{ __('Paid') }}</th>
    <td>{{ $currency }}{{ number_format($paid, 2) }}</td>
</tr>
<tr>
    <th scope="row">{{ __('Orders') }}</th>
    <td>{{ $currency }}{{ number_format($orders, 2) }}</td>
</tr>