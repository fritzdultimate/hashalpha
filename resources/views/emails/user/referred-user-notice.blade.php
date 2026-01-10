Subject: New Referral Joined Your Network

<!DOCTYPE html>

<html lang="en" style="margin:0; padding:0; background:#0f0f11;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>

<body style="margin:0; padding:0; background:#0f0f11; font-family:Arial, Helvetica, sans-serif;">

```
<!-- Outer Container -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#0f0f11" style="padding:30px 0;">
    <tr>
        <td align="center">

            <!-- Card -->
            <table width="100%" cellpadding="0" cellspacing="0"
                style="max-width:520px; background:#1a1a1f; border-radius:14px; padding:32px; border:1px solid #2b2b33; color:#ffffff;">

                <!-- Logo -->
                <tr>
                    <td align="center" style="padding-bottom:20px;">
                        <img src="{{ asset('img/logo/logo-white.png') }}" alt="Logo"
                            style="display:block; width:110px; opacity:0.9;">
                    </td>
                </tr>

                <!-- Title -->
                <tr>
                    <td style="font-size:20px; font-weight:bold; text-align:center; padding-bottom:10px;">
                        {{ $subject }}
                    </td>
                </tr>

                <!-- Message -->
                <tr>
                    <td style="font-size:14px; line-height:22px; color:#d1d1d6; text-align:center; padding:10px 0 20px;">
                        Hello <strong>{{ $referrer->name }}</strong>,<br>
                        We’re excited to let you know that a new user has joined your referral network.
                    </td>
                </tr>

                <!-- Referral Info -->
                <tr>
                    <td>
                        <div style="background:#111114; border-radius:12px; padding:20px; text-align:center;">
                            <p style="margin:0; font-size:13px; color:#9CA3AF;">Referred User</p>
                            <p style="margin:5px 0 15px; font-size:18px; font-weight:600; color:#ffffff;">
                                {{ $referredUser->name }}
                            </p>

                            <p style="margin:0; font-size:13px; color:#9CA3AF;">Referral Level</p>
                            <p style="margin:5px 0 0; font-size:22px; font-weight:700; color:#22d3ee;">
                                Level {{ $level }}
                            </p>
                        </div>
                    </td>
                </tr>

                <!-- Info Text -->
                <tr>
                    <td style="color:#8d8d95; font-size:12px; padding-top:20px;">
                        <p>This referral has been successfully added to your downline structure.</p>
                        <p>Any eligible rewards or commissions will be calculated automatically based on your plan.</p>
                    </td>
                </tr>

                <!-- Closing -->
                <tr>
                    <td style="font-size:12px; font-weight:500; padding-top:15px;">
                        <p>Keep growing your network 🚀</p>
                        <p>{{ env('APP_NAME') }} Team</p>
                    </td>
                </tr>

                <!-- Divider -->
                <tr>
                    <td style="border-bottom:1px solid #2b2b33; padding:20px 0;"></td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center" style="padding:20px 0; color:#9CA3AF;">
                        <p style="margin:0; font-size:11px;">
                            You are receiving this email because you are part of the {{ env('APP_NAME') }} referral program.
                        </p>
                        <p style="margin:10px 0 0; font-size:11px;">
                            © {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
                        </p>
                    </td>
                </tr>

                <!-- Social Icons -->
                <tr>
                    <td align="center" style="padding-top:20px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                            <tr>
                                <td style="padding:0 6px;">
                                    <img src="{{ asset('svgs/socials/instagram.svg') }}" width="22" height="22" style="filter:invert(40%);">
                                </td>
                                <td style="padding:0 6px;">
                                    <img src="{{ asset('svgs/socials/facebook.svg') }}" width="22" height="22" style="filter:invert(40%);">
                                </td>
                                <td style="padding:0 6px;">
                                    <img src="{{ asset('svgs/socials/x.svg') }}" width="22" height="22" style="filter:invert(40%);">
                                </td>
                                <td style="padding:0 6px;">
                                    <img src="{{ asset('svgs/socials/linkedin.svg') }}" width="22" height="22" style="filter:invert(40%);">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
```

</body>
</html>
