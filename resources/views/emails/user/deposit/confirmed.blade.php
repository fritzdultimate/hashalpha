@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, your deposit has been successfully confirmed! ✅
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
                ${{ number_format($deposit->amount, 2) }}
            </div>

            <p style="margin-top:10px; font-size:12px; color:#9CA3AF;">
                This amount has been credited to your wallet.
            </p>
        </td>
    </tr>

    <!-- Payment Method -->
    <tr>
        <td align="center" style="padding-bottom:18px;">
            <span style="
                display:inline-block;
                background:#0f172a;
                border:1px solid #334155;
                color:#22c55e;
                font-size:12px;
                font-weight:600;
                letter-spacing:0.4px;
                padding:6px 14px;
                border-radius:999px;
            ">
                {{ strtoupper($deposit->wallet->currency ?? 'Crypto') }}
            </span>
        </td>
    </tr>

    <!-- Deposit Details Table -->
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
                    <td align="right" style="padding:6px 0; color:#22c55e;">
                        Confirmed
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Transaction ID</td>
                    <td align="right" style="padding:6px 0; font-size:11px; color:#9CA3AF;">
                        {{ $deposit->tx_id ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Credited At</td>
                    <td align="right" style="padding:6px 0;">
                        {{ $deposit->updated_at->format('M d, Y • H:i') }}
                    </td>
                </tr>

                @if($deposit->bonus > 0)
                <tr>
                    <td style="padding:6px 0;">Bonus</td>
                    <td align="right" style="padding:6px 0; color:#22c55e;">
                        ${{ number_format($deposit->bonus, 2) }}
                        @if($deposit->bonus_expires_at)
                            <span style="font-size:11px; color:#9CA3AF;">
                                (Valid until {{ \Carbon\Carbon::parse($deposit->bonus_expires_at)->format('M d, Y') }})
                            </span>
                        @endif
                    </td>
                </tr>
                @endif

            </table>
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Thank you for your deposit. You can now use your funds for trading, investments, or other services on our platform.
            <br><br>
            If you notice any issues with your deposit, please contact our support team immediately.
        </td>
    </tr>
@endsection
 