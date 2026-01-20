@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, welcome to <strong>HashAlpha</strong>! Your account has been successfully created.
        </td>
    </tr>

    <!-- Hero / Welcome Box -->
    <tr>
        <td align="center" style="padding:20px 0;">
            <div style="
                display:inline-block;
                background:#020617;
                border:1px solid #1e293b;
                border-radius:14px;
                padding:20px 28px;
                font-size:28px;
                font-weight:700;
                letter-spacing:0.5px;
                color:#38bdf8;
            ">
                Account Ready
            </div>
        </td>
    </tr>

    <!-- Intro Text -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding:12px 0 22px; line-height:20px;">
            Congratulations on successfully creating your account with <strong>{{ env('APP_NAME') }}</strong>. 
            We’re thrilled to have you join our community and support your participation in our infrastructure-driven platform.
        </td>
    </tr>

    <!-- Steps to Get Started -->
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0"
                style="
                    background:#0b0b14;
                    border-radius:12px;
                    padding:18px;
                    font-size:13px;
                    color:#c7c7cc;
                    border:1px solid #1f2937;
                ">
                <tr>
                    <td style="font-weight:600; padding-bottom:8px; color:#ffffff;">
                        Next Steps to Get Started
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">
                        <strong>1. Fund Your Account</strong><br>
                        Log in to your dashboard and navigate to the Deposit section to fund your wallet.
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">
                        <strong>2. Choose a Participation Plan</strong><br>
                        Select a plan that aligns with your objectives and begin participating in Ethereum validator infrastructure.
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">
                        <strong>3. Monitor Your Rewards</strong><br>
                        Once active, your account will begin accruing rewards based on your selected plan and network participation.
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Account Details -->
    <tr>
        <td style="padding-top:20px;">
            <table width="100%" cellpadding="0" cellspacing="0"
                style="
                    background:#0f0f14;
                    border-radius:12px;
                    padding:18px;
                    font-size:13px;
                    color:#c7c7cc;
                    border:1px solid #1f2937;
                ">
                <tr>
                    <td style="font-weight:600; padding-bottom:8px; color:#ffffff;">Your Account Details</td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Name: <strong>{{ $user->name }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Email: <strong>{{ $user->email }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Phone: <strong>{{ $user->phone ?? 'N/A' }}</strong></td>
                </tr>
                <tr>
                    <td style="padding:6px 0;">Username: <strong>{{ $user->name }}</strong></td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Info / Footer -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            At <strong>{{ env('APP_NAME') }}</strong>, we focus on transparency, infrastructure participation, and long-term sustainability.
            <br><br>
            If you need assistance at any stage, our support team is available to help: 
            <a href="mailto:support@hashalpha.io" style="color:#38bdf8; text-decoration:none;">support@hashalpha.io</a>.
            <br><br>
            Thank you for joining HashAlpha. We look forward to having you as part of our network!
        </td>
    </tr>
@endsection
