@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, good news! 🎉
        </td>
    </tr>

    <!-- Bonus Box -->
    <tr>
        <td align="center" style="padding:22px 0;">
            <div style="
                display:inline-block;
                background:#0f172a;
                border:1px solid #334155;
                border-radius:14px;
                padding:20px 34px;
                font-size:24px;
                font-weight:700;
                letter-spacing:0.5px;
                color:#22c55e;
            ">
                You received a bonus of ${{ number_format($bonus, 2) }}!
            </div>

            @if($expires_at)
                <p style="margin-top:10px; font-size:12px; color:#9CA3AF;">
                    Bonus valid until {{ \Carbon\Carbon::parse($expires_at)->format('M d, Y') }}
                </p>
            @endif
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Your bonus has been automatically added to your wallet.
            <br><br>
            Enjoy your extra funds! If you have any questions, contact our support team.
        </td>
    </tr>
@endsection
