<!DOCTYPE html>
<html>
<head>
    <title>Commission Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Commission Invoice</h2>
        <p>Member ID: {{ $commission->history_member_id }}</p>
    </div>

    <table>
        <tr><th>Description</th><td>{{ $commission->history_description }}</td></tr>
        <tr><th>Amount</th><td>${{ number_format($commission->history_amount, 2) }}</td></tr>
        <tr><th>Date</th><td>{{ \Carbon\Carbon::parse($commission->history_datetime)->format('d M Y') }}</td></tr>
        <tr><th>Transaction ID</th><td>{{ $commission->history_transaction_id ?: '—' }}</td></tr>
    </table>
</body>
</html>