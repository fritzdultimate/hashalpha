<!DOCTYPE html>
<html lang="en" style="margin:0; padding:0; background:#0f0f11;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>

<body style="margin:0; padding:0; background:#0f0f11; font-family:Arial, Helvetica, sans-serif;">

    <!-- Outer Container -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#0f0f11" style="padding:30px 0;">
        <tr>
            <td align="center">

                <!-- Card -->
                <table width="100%" cellpadding="0" cellspacing="0"
                    style="max-width:520px; background:#1a1a1f; border-radius:14px; padding:32px; border:1px solid #2b2b33; color:#ffffff;">

                    <!-- Logo / Header -->
                    <tr>
                        <td align="center" style="padding-bottom:20px;">
                            <img src="{{ asset('img/logo/logo-white.png') }}" alt="Logo"
                                style="display:block; width:110px; opacity:0.9;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td
                            style="font-size:20px; font-weight:bold; text-align:center; padding-bottom:10px; color:#ffffff;">
                            {{ $subject }}
                        </td>
                    </tr>

                    <!-- Message -->
                    <tr>
                        <td
                            style="font-size:14px; line-height:22px; color:#d1d1d6; text-align:center; padding:10px 0 20px;">
                            Your One-Time Password (OTP) for completing your activity:
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div
                                style="text-align: center; padding: 20px 0; font-size: 35px; font-weight: 600; color: #22d3ee;">
                                {{ $otp }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="color:#8d8d95; font-size: 12px;">
                            <p style="color:#8d8d95; font-size: 12px;">This code will expire in 10 minutes.</p>
                            <p style="color:#8d8d95; font-size: 12px;">Do not share this code with anyone — not even our support team.</p>

                            <p style="color:#8d8d95; font-size: 12px;">If you didn’t request this code, please secure your account immediately.</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-size: 11px; font-weight: 500;">
                            <p style="color:#8d8d95; font-size: 12px;">Thank you,</p>
                            <p style="color:#8d8d95; font-size: 12px;">{{ env('APP_NAME') }} Team</p>
                        </td>
                    </tr>

                    <!-- CTA Button (optional) -->
                    <tr style="display: none;">
                        <td align="center" style="padding-bottom:25px;">
                            <a href="#" style="background:#22d3ee; 
                                      color:#000000; 
                                      text-decoration:none; 
                                      padding:12px 24px; 
                                      display:inline-block; 
                                      border-radius:8px; 
                                      font-size:14px; 
                                      font-weight:bold;">
                                Link text
                            </a>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style="border-bottom:1px solid #2b2b33; padding-bottom:20px;"></td>
                    </tr>

                    <!-- Footer Message -->
                    <!-- Footer -->
                    <tr>
                        <td align="center"
                            style="padding:30px 20px 20px; color:#9CA3AF; font-size:11px; font-family:Arial, sans-serif;">

                            <p style="margin:0; padding:0; color:#9CA3AF;">
                                You are receiving this email because you have an account with <strong
                                    style="color:#E5E7EB;">{{ env('APP_NAME') }}</strong>
                                or recently performed an action that requires notification.
                            </p>

                            <p style="margin:15px 0 0; padding:0; color:#9CA3AF;">
                                If you did not request this email, you can safely ignore it.
                            </p>

                            <p style="margin:15px 0 0; padding:0; color:#6B7280; font-size:11px;">
                                © {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
                            </p>

                            <p style="margin:8px 0 0; padding:0; color:#6B7280; font-size:11px;">
                                100% Secure • Powered by {{ env('APP_NAME') }} Infrastructure
                            </p>

                            <p style="margin:15px 0 0; padding:0; color:#9CA3AF; font-size:10px;">
                                <a href="#" style="color:#4B82F2; text-decoration:none;">Privacy Policy</a>
                                &nbsp;•&nbsp;
                                <a href="#" style="color:#4B82F2; text-decoration:none;">Support</a> &nbsp;•&nbsp;
                                <a href="#" style="color:#4B82F2; text-decoration:none;">Unsubscribe</a>
                            </p>

                        </td>
                    </tr>


                    <!-- Social -->
                    <!-- Social Icons -->
                    <tr>
                        <td align="center" style="padding-top:25px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td style="padding:0 6px;">
                                        <a href="#" target="_blank">
                                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/instagram.svg"
                                                width="24" height="24" alt="Instagram"
                                                style="display:block; filter: invert(40%);">
                                        </a>
                                    </td>

                                    <td style="padding:0 6px;">
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/facebook.svg"
                                                width="24" height="24" alt="Facebook"
                                                style="display:block; filter: invert(40%);">
                                        </a>
                                    </td>

                                    <td style="padding:0 6px;">
                                        <a href="#" target="_blank">
                                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/x.svg"
                                                width="24" height="24" alt="Twitter/X"
                                                style="display:block; filter: invert(40%);">
                                        </a>
                                    </td>

                                    <td style="padding:0 6px;">
                                        <a href="#" target="_blank">
                                            <img src="https://cdn.jsdelivr.net/npm/simple-icons@v9/icons/linkedin.svg"
                                                width="24" height="24" alt="LinkedIn"
                                                style="display:block; filter: invert(40%);">
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <!-- End Spacer -->
                    <tr>
                        <td style="padding-top:10px;"></td>
                    </tr>

                </table>
                <!-- End Card -->

                <!-- Unsubscribe -->
                <table width="100%" style="max-width:520px; padding-top:15px;">
                    <tr>
                        <td align="center" style="font-size:11px; color:#5f5f68;">
                            © {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.<br>
                            If you did not request this email, you can ignore it.
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>