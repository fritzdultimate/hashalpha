@extends('emails.layouts.app')

@push('email-styles')
<style>
    /* Styles for the admin-authored rich text body. Inline-friendly fallbacks
       are also applied via the tags below for clients that strip <style>. */
    .halpha-rich-body p { margin: 0 0 14px; }
    .halpha-rich-body p:last-child { margin-bottom: 0; }
    .halpha-rich-body a { color: #38bdf8; text-decoration: underline; }
    .halpha-rich-body strong, .halpha-rich-body b { color: #ffffff; }
    .halpha-rich-body h1, .halpha-rich-body h2, .halpha-rich-body h3 {
        color: #ffffff; margin: 0 0 12px; line-height: 1.3;
    }
    .halpha-rich-body ul, .halpha-rich-body ol { margin: 0 0 14px; padding-left: 20px; }
    .halpha-rich-body li { margin-bottom: 6px; }
    .halpha-rich-body blockquote {
        margin: 0 0 14px; padding: 10px 16px; border-left: 3px solid #38bdf8;
        background: #0b0b14; color: #c7c7cc; border-radius: 4px;
    }
    .halpha-rich-body img { max-width: 100%; border-radius: 8px; }
    .halpha-rich-body hr { border: none; border-top: 1px solid #2b2b33; margin: 18px 0; }
</style>
@endpush

@section('contents')
    @if ($user)
        <tr>
            <td style="font-size:14px; color:#d1d1d6; text-align:left; padding-bottom:16px;">
                Hi {{ $user->first_name ?? $user->name ?? 'there' }},
            </td>
        </tr>
    @endif

    <!-- Admin authored content -->
    <tr>
        <td>
            <table width="100%" cellpadding="0" cellspacing="0"
                style="
                    background:#0f0f14;
                    border-radius:12px;
                    padding:20px;
                    border:1px solid #1f2937;
                ">
                <tr>
                    <td class="halpha-rich-body" style="font-size:14px; color:#d1d1d6; text-align:left; line-height:22px;">
                        {!! $body !!}
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Footer note -->
    <tr>
        <td style="padding-top:22px; font-size:12px; color:#8d8d95; text-align:center; line-height:18px;">
            This message was sent to you by the <strong>{{ $appName }}</strong> team.
            <br><br>
            If you weren't expecting this email or need help, contact us at
            <a href="mailto:support@hashalpha.io" style="color:#38bdf8; text-decoration:none;">support@vertexstake.com</a>.
        </td>
    </tr>
@endsection
