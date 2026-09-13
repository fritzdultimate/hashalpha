<?php

namespace App\Mail;

use App\Models\Stake;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompoundingEndedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Stake $stake)
    {
        $this->subject = 'Compounding Stake Ended — ' . ($this->stake->user->affiliate_code ?? $this->stake->user->email);
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
            markdown: 'emails.admin.compounding-ended',
            with: [
                'user' => $this->stake->user,
                'stake' => $this->stake,
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
