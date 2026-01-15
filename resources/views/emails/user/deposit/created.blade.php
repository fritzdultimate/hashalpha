<!DOCTYPE html>
<html lang="en" style="margin:0; padding:0; background:#0f0f11;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>

<body style="margin:0; padding:0; background:#0f0f11; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
<tr>
<td align="center">

<!-- Card -->
<table width="100%" cellpadding="0" cellspacing="0"
       style="max-width:520px; background:#1a1a1f; border-radius:14px; padding:32px; border:1px solid #2b2b33; color:#ffffff;">

<!-- Logo -->
<tr>
    <td align="center" style="padding-bottom:24px;">
        <img src="{{ asset('img/logo/logo-white.png') }}" alt="{{ $appName }}"
             style="width:120px; opacity:0.95;">
    </td>
</tr>

<!-- Title -->
<tr>
    <td style="font-size:22px; font-weight:700; text-align:center; padding-bottom:10px;">
        {{ $subject }}
    </td>
</tr>

<!-- Greeting -->
<tr>
    <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:20px;">
        Hi {{ $user->name }}, your deposit has been successfully created, status will update automatically.
    </td>
</tr>

<!-- Amount Box -->
<tr>
    <td align="center" style="padding:20px 0;">
        <div style="
            display:inline-block;
            background:#0f172a;
            border:1px solid #1e293b;
            border-radius:12px;
            padding:18px 28px;
            font-size:32px;
            font-weight:700;
            color:#22d3ee;
        ">
            {{ number_format($deposit->amount_paid ?? $deposit->amount, 2) }}
        </div>

        <p style="margin-top:8px; font-size:12px; color:#9CA3AF;">
            Amount credited to your wallet
        </p>
    </td>
</tr>

<!-- Details -->
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"
       style="background:#0f0f14; border-radius:10px; padding:16px; font-size:13px; color:#c7c7cc;">

<tr>
    <td style="padding:6px 0;">Deposit ID</td>
    <td align="right" style="padding:6px 0; color:#ffffff;">
        #{{ $deposit->id }}
    </td>
</tr>

<tr>
    <td style="padding:6px 0;">Status</td>
    <td align="right" style="padding:6px 0; color:#22c55e;">
        Completed
    </td>
</tr>

<tr>
    <td style="padding:6px 0;">Payment Method</td>
    <td align="right" style="padding:6px 0;">
        {{ strtoupper($deposit->gateway ?? 'Crypto') }}
    </td>
</tr>

<tr>
    <td style="padding:6px 0;">Transaction ID</td>
    <td align="right" style="padding:6px 0; font-size:11px;">
        {{ $deposit->tx_id ?? 'N/A' }}
    </td>
</tr>

<tr>
    <td style="padding:6px 0;">Date</td>
    <td align="right" style="padding:6px 0;">
        {{ $deposit->processed_at?->format('M d, Y • H:i') }}
    </td>
</tr>

</table>
</td>
</tr>

<!-- Info -->
<tr>
    <td style="padding-top:20px; font-size:12px; color:#8d8d95; text-align:center;">
        Your wallet balance has been updated and is now available for use.
        If you did not initiate this deposit, please contact support immediately.
    </td>
</tr>

<!-- Divider -->
<tr>
    <td style="border-bottom:1px solid #2b2b33; padding:24px 0;"></td>
</tr>

<!-- Footer -->
<tr>
<td align="center" style="padding-top:20px; font-size:11px; color:#9CA3AF;">
    © {{ date('Y') }} {{ $appName }}. All rights reserved.<br>
    Secure • Encrypted • Trusted Infrastructure
</td>
</tr>

</table>
<!-- End Card -->

</td>
</tr>
</table>

</body>
</html>
