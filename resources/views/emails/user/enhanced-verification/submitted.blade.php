@extends('emails.layouts.app')

@section('contents')
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ ucfirst($user->name) }},
        </td>
    </tr>

    <tr>
        <td align="center" style="padding:22px 0;">
            <div style="
                display:inline-block;
                background:#0f172a;
                border:1px solid #334155;
                border-radius:14px;
                padding:20px 34px;
                font-size:18px;
                font-weight:600;
                letter-spacing:0.2px;
                color:#f1f5f9;
            ">
                Your enhanced verification documents have been submitted!
            </div>
        </td>
    </tr>

    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Thank you for submitting the additional documents for enhanced verification.
            Our team will manually review them, and this review is typically completed within 24–48 hours.
            You'll be notified as soon as a decision is made.
        </td>
    </tr>

    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            If you have any questions, feel free to contact our support team at
            <a href="mailto:{{ env('SUPPORT_EMAIL') }}" style="color:#22c55e; text-decoration:none;">{{ env('SUPPORT_EMAIL') }}</a>.
        </td>
    </tr>

    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Regards,<br>
            The {{ $appName }} Team
        </td>
    </tr>
@endsection
