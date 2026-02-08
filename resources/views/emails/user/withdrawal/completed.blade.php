@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, your withdrawal has been successfully processed! ✅
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
                color:#22c55e;
            ">
                ${{ number_format(($withdrawal->meta['total_to_debit'] ?? $withdrawal->amount) - ($withdrawal->meta['fee'] ?? 0), 2) }}
            </div>

            <p style="margin-top:10px; font-size:12px; color:#9CA3AF;">
                This amount has been sent to your selected withdrawal destination.
            </p>
        </td>
    </tr>

    <!-- Withdrawal Source -->
    <tr>
        <td align="center" style="padding-bottom:18px;">
            <span style="
                display:inline-block;
                background:#0f172a;
                border:1px solid #334155;
                color:#38bdf8;
                font-size:12px;
                font-weight:600;
                letter-spacing:0.4px;
                padding:6px 14px;
                border-radius:999px;
            ">
                {{ strtoupper(str_replace('_', ' ', $asset ?? 'Wallet Balance')) }}
            </span>
        </td>
    </tr>

    <!-- Withdrawal Details Table -->
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
                    <td style="padding:6px 0;">Withdrawal Fee</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">
                        ${{ ($withdrawal->meta['fee'] ?? 0) }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Status</td>
                    <td align="right" style="padding:6px 0; color:#22c55e;">
                        Completed
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Destination</td>
                    <td align="right" style="padding:6px 0; font-size:11px; color:#9CA3AF;">
                        {{ $withdrawal->destination ?? 'External Wallet' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Processed At</td>
                    <td align="right" style="padding:6px 0;">
                        {{ $withdrawal->updated_at->format('M d, Y • H:i') }}
                    </td>
                </tr>

                @if($withdrawal->tx_id)
                <tr>
                    <td style="padding:6px 0;">Transaction ID</td>
                    <td align="right" style="padding:6px 0; font-size:11px; color:#9CA3AF;">
                        {{ $withdrawal->tx_id }}
                    </td>
                </tr>
                @endif

            </table>
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Your withdrawal has been completed successfully and should reflect shortly depending on the network or payment method used.
            <br><br>
            If you did not initiate this withdrawal or notice any discrepancy, please contact our support team immediately.
        </td>
    </tr>
@endsection
