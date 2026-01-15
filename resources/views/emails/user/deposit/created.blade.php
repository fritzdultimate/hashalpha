@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, your deposit has been successfully initiated.
            We’re currently waiting for network confirmation.
        </td>
    </tr>

    <!-- Amount Box -->
    <tr>
        <td align="center" style="padding:22px 0;">
            <div style="
                display:inline-block;
                background:#020617;
                border:1px solid #1e293b;
                border-radius:14px;
                padding:20px 34px;
                font-size:34px;
                font-weight:700;
                letter-spacing:0.5px;
                color:#38bdf8;
            ">
                {{ number_format($deposit->amount, 2) }}
            </div>

            <p style="margin-top:10px; font-size:12px; color:#9CA3AF;">
                Deposit amount submitted
            </p>
        </td>
    </tr>

    <!-- Status Badge -->
    <tr>
        <td align="center" style="padding-bottom:18px;">
            <span style="
                display:inline-block;
                background:#0f172a;
                border:1px solid #334155;
                color:#facc15;
                font-size:11px;
                font-weight:600;
                letter-spacing:0.4px;
                padding:6px 14px;
                border-radius:999px;
                text-transform:uppercase;
            ">
                Pending Confirmation
            </span>
        </td>
    </tr>

    <!-- Details -->
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0"
                style="
                    background:#0b0b10;
                    border-radius:12px;
                    padding:18px;
                    font-size:13px;
                    color:#c7c7cc;
                    border:1px solid #1f2937;
                ">

                <tr>
                    <td style="padding:6px 0;">Deposit ID</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">
                        #{{ $deposit->id }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Status</td>
                    <td align="right" style="padding:6px 0; color:#facc15;">
                        Pending
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
                    <td align="right" style="padding:6px 0; font-size:11px; color:#9CA3AF;">
                        {{ $deposit->tx_id ?? 'Will be available after confirmation' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Created At</td>
                    <td align="right" style="padding:6px 0;">
                        {{ $deposit->created_at->format('M d, Y • H:i') }}
                    </td>
                </tr>

            </table>
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            This deposit will be credited to your wallet automatically once the
            required network confirmations are completed.
            <br><br>
            If you did not initiate this deposit, please contact our support team immediately.
        </td>
    </tr>
@endsection
