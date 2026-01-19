<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Settings OTP</title>
</head>
<body style="margin:0; padding:0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background:#f1f5f9;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f1f5f9; padding:40px 0;">
    <tr>
        <td align="center">
            <table width="480" cellpadding="0" cellspacing="0" border="0" style="background:white; border-radius:16px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
                <!-- Header -->
                <tr>
                    <td style="background:#0ea5e9; color:white; padding:32px 40px; text-align:center;">
                        <h1 style="margin:0; font-size:28px;">Withdrawal Settings Update</h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:40px; color:#1e293b; line-height:1.6; font-size:16px;">
                        <p>Dear Admin,</p>

                        <p>You are attempting to update <strong>Withdrawal Payment Settings</strong>.</p>

                        <p style="text-align:center; margin:32px 0 16px; font-size:17px; color:#334155;">
                            Your verification OTP is:
                        </p>

                        <div style="text-align:center; margin:24px 0 32px;">
                            <div style="
                                background:#f0f9ff;
                                border:3px solid #bae6fd;
                                border-radius:12px;
                                padding:20px 48px;
                                font-size:42px;
                                font-weight:700;
                                letter-spacing:12px;
                                color:#0f766e;
                                font-family: monospace, 'Courier New', Courier, monospace;
                                display:inline-block;
                                min-width:240px;
                                user-select: all;
                                -webkit-user-select: all;
                                -moz-user-select: all;
                                -ms-user-select: all;
                                cursor:text !important;
                                text-align:center;
                            ">
                                {{ $otp }}
                            </div>

                            <div style="margin-top:12px; font-size:14px; color:#64748b;">
                                Click inside → Ctrl + C (or right-click → Copy)
                            </div>
                        </div>

                        <p style="text-align:center; font-size:16px; color:#64748b; margin:0 0 24px;">
                            This OTP is valid for <strong>60 seconds</strong> only.
                        </p>

                        <p style="margin:24px 0 0;">
                            If you did not request this change, please ignore this email or contact support immediately.
                        </p>

                        <p style="margin-top:32px;">
                            Regards,<br>
                            <strong>Your Platform Team</strong>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>


</body>
</html>
