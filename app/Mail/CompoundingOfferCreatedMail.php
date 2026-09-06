<?php

namespace App\Mail;

use App\Models\CompoundingOffer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompoundingOfferCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CompoundingOffer $offer)
    {
        $this->subject = 'A Compounding Offer Is Waiting For You';
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
            markdown: 'emails.user.compounding.offered',
            with: [
                'user' => $this->offer->user,
                'offer' => $this->offer,
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
