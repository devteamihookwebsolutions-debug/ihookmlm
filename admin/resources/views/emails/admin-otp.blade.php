<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>OTP Code</title>
</head>
<body style="background:#f3f4f6;font-family:Arial,sans-serif;padding:20px;">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">

<table width="400" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;border:1px solid #e5e7eb;">

    <!-- Header -->
    <tr>
        <td style="background:#2563eb;color:#ffffff;text-align:center;padding:16px;font-size:22px;font-weight:bold;border-radius:12px 12px 0 0;">
            {{ config('app.name') }}
        </td>
    </tr>

    <!-- Content -->
    <tr>
        <td style="padding:32px;text-align:center;">
            <p style="color:#374151;font-size:16px;">
                Hello <strong>{{ $username }}</strong>,
            </p>

            <p style="color:#374151;font-size:14px;margin:16px 0;">
                Use the following OTP to proceed:
            </p>

            <!-- OTP Box -->
            <div style="display:inline-block;background:#f3f4f6;border:1px solid #d1d5db;
                        border-radius:8px;padding:16px 32px;font-size:28px;
                        font-weight:bold;letter-spacing:6px;color:#2563eb;">
                {{ $otp }}
            </div>

            <p style="color:#6b7280;font-size:12px;margin-top:16px;">
                This OTP is valid for 10 minutes.
            </p>
        </td>
    </tr>

    <!-- Footer -->
    <tr>
        <td style="background:#f9fafb;color:#9ca3af;font-size:12px;
                   text-align:center;padding:12px;border-top:1px solid #e5e7eb;
                   border-radius:0 0 12px 12px;">
            © {{ date('Y') }} {{ config('app.name') }}
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>
