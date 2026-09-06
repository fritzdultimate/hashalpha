<?php

namespace App\Mail;

use App\Models\CompoundingOffer;
use App\Models\Stake;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompoundingOfferAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public CompoundingOffer $offer, public Stake $stake)
    {
        $this->subject = 'Your Compounding Term Has Started';
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
            markdown: 'emails.user.compounding.accepted',
            with: [
                'user' => $this->offer->user,
                'offer' => $this->offer,
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
