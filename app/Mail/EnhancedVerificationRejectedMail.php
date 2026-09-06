<?php

namespace App\Mail;

use App\Models\EnhancedVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnhancedVerificationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EnhancedVerification $verification)
    {
        $this->subject = 'Enhanced Verification Update';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.enhanced-verification.rejected',
            with: [
                'user' => $this->verification->user,
                'verification' => $this->verification,
                'subject' => $this->subject,
                'appName' => config('app.name'),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
