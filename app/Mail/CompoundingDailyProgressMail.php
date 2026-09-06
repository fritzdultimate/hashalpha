<?php

namespace App\Mail;

use App\Models\Stake;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompoundingDailyProgressMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Stake $stake, public string $dailyAmount)
    {
        $this->subject = 'Your Daily Compounding Update';
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
            markdown: 'emails.user.compounding.daily-progress',
            with: [
                'user' => $this->stake->user,
                'stake' => $this->stake,
                'dailyAmount' => $this->dailyAmount,
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
