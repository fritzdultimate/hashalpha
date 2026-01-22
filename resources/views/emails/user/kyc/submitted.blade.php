@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ ucfirst($user->name) }},
        </td>
    </tr>

    <!-- Main Box -->
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
                Your KYC documents have been successfully submitted!
            </div>
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Thank you for completing your identity verification.  
            Our team will review your documents within 24–48 hours.  
            Once approved, you will have full access to all features on {{ $appName }}.
        </td>
    </tr>

    <!-- Optional Support -->
    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            If you have any questions, feel free to contact our support team at 
            <a href="mailto:{{ env('SUPPORT_EMAIL') }}" style="color:#22c55e; text-decoration:none;">{{ env('SUPPORT_EMAIL') }}</a>.
        </td>
    </tr>

    <!-- Closing -->
    <tr>
        <td style="padding-top:18px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Regards,<br>
            The {{ $appName }} Team
        </td>
    </tr>
@endsection
