<!DOCTYPE html>
<html>
<head>
    <title>Package Invoice</title>
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
        <h2>Package Purchase Invoice</h2>
        <p>Member: {{ $package->member->members_firstname }} {{ $package->member->members_lastname }}</p>
    </div>

    <table>
        <tr><th>Plan</th><td>{{ $package->matrix->matrix_name ?? '—' }}</td></tr>
        <tr><th>Package</th><td>{{ $package->package->package_name ?? '—' }}</td></tr>
        <tr><th>Amount</th><td>${{ number_format($package->paymenthistory_amount, 2) }}</td></tr>
        <tr><th>Date</th><td>{{ $package->paymenthistory_date->format('d M Y') }}</td></tr>
        <tr><th>Status</th><td>{{ $package->paymenthistory_status == 1 ? 'Active' : 'Inactive' }}</td></tr>
        <tr><th>Transaction ID</th><td>{{ $package->paymenthistory_trans_id ?: '—' }}</td></tr>
    </table>
</body>
</html>