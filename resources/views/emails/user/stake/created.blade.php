@extends('emails.layouts.app')

@section('contents')
    <!-- Greeting -->
    <tr>
        <td style="font-size:14px; color:#d1d1d6; text-align:center; padding-bottom:18px;">
            Hi {{ $user->name }}, your stake has been successfully created!
        </td>
    </tr>

    <!-- Stake Amount Box -->
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
                ${{ number_format($stake->amount, 2) }}
            </div>

            <p style="margin-top:10px; font-size:12px; color:#9CA3AF;">
                Stake amount
            </p>
        </td>
    </tr>

    <!-- Plan & Duration -->
    <tr>
        <td style="padding-bottom:18px; text-align:center;">
            <p style="font-size:13px; color:#c7c7cc; margin:4px 0;">
                <strong>Plan:</strong> {{ $plan->name ?? 'N/A' }}
            </p>
            <p style="font-size:13px; color:#c7c7cc; margin:4px 0;">
                <strong>Daily ROI:</strong> {{ $plan->daily_roi ?? 0 }}%
            </p>
            <p style="font-size:13px; color:#c7c7cc; margin:4px 0;">
                <strong>Start Date:</strong> {{ $stake->created_at->format('M d, Y') }}
            </p>
            <p style="font-size:13px; color:#c7c7cc; margin:4px 0;">
                <strong>Expected End Date:</strong> {{ $stake->expected_end_date->format('M d, Y') }}
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
                color:#38bdf8;
                font-size:11px;
                font-weight:600;
                letter-spacing:0.4px;
                padding:6px 14px;
                border-radius:999px;
                text-transform:uppercase;
            ">
                {{ ucfirst($stake->status) }}
            </span>
        </td>
    </tr>

    <!-- Stake Details Table -->
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
                    <td style="padding:6px 0;">Stake ID</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">
                        #{{ $stake->id }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Plan ID</td>
                    <td align="right" style="padding:6px 0; color:#ffffff;">
                        {{ $plan->id ?? 'N/A' }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Amount</td>
                    <td align="right" style="padding:6px 0; color:#38bdf8;">
                        ${{ number_format($stake->amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Status</td>
                    <td align="right" style="padding:6px 0; color:#facc15;">
                        {{ ucfirst($stake->status) }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Created At</td>
                    <td align="right" style="padding:6px 0;">
                        {{ $stake->created_at->format('M d, Y • H:i') }}
                    </td>
                </tr>

                <tr>
                    <td style="padding:6px 0;">Expected End Date</td>
                    <td align="right" style="padding:6px 0;">
                        {{ $stake->expected_end_date->format('M d, Y') }}
                    </td>
                </tr>

            </table>
        </td>
    </tr>

    <!-- Info -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            Your stake will generate rewards according to the selected plan. <br>
            If you did not initiate this stake, please contact our support team immediately.
        </td>
    </tr>
@endsection
