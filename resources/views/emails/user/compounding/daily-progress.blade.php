@extends('emails.layouts.app')

@section('contents')
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, here's today's update on your compounding term.
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
                ${{ number_format($dailyAmount, 2) }}
            </div>
            <p style="margin-top:10px; font-size:12px; color:#9CA3AF; text-align:center;">
                Added today
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
                    <td style="padding:6px 0;">Locked Amount</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">${{ number_format($stake->amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Term Ends</td>
                    <td align="right" style="padding:6px 0;">{{ $stake->expected_end_date->format('M d, Y') }}</td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            This is a running progress update only. A final summary will be sent once your term completes.
        </td>
    </tr>
@endsection
