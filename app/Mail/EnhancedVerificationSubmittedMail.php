<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnhancedVerificationSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public User $user)
    {
        $this->subject = 'Enhanced Verification Submitted';
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
            markdown: 'emails.user.enhanced-verification.submitted',
            with: [
                'user' => $this->user,
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
