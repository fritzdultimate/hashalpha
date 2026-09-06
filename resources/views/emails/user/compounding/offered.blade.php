@extends('emails.layouts.app')

@section('contents')
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, your stake has matured! You have the option to reinvest it into a new compounding term.
        </td>
    </tr>

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
                {{ $offer->min_roi }}% – {{ $offer->max_roi }}%
            </div>
            <p style="margin-top:10px; font-size:12px; color:#9CA3AF; text-align:center;">
                Daily ROI for {{ $offer->duration_days }} days
            </p>
        </td>
    </tr>

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
                    <td style="padding:6px 0;">Term</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">{{ $offer->duration_days }} days</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Offer Expires</td>
                    <td align="right" style="padding:6px 0; color:#facc15;">
                        {{ $offer->expires_at?->format('M d, Y') ?? 'N/A' }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            This is entirely optional. If you accept, the reinvested amount is locked for the full term and
            withdrawals will not be available until it completes. You can review and respond to this offer
            from your dashboard at any time before it expires. If you'd rather not, no action is needed.
        </td>
    </tr>
@endsection
