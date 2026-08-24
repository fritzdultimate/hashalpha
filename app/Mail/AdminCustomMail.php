<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * A one-off, professionally branded email composed by an admin from the
 * Filament "Send Custom Email" page and sent to any user or arbitrary
 * email address. It reuses the same platform email shell (logo, header,
 * footer) as the rest of the transactional emails so it reads as an
 * official message from the platform rather than a plain-text blast.
 */
class AdminCustomMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  string  $emailSubject  The subject line chosen by the admin.
     * @param  string  $body  Sanitized HTML produced by the admin's rich text editor.
     * @param  User|null  $user  The matching platform user, when the recipient is a known user.
     */
    public function __construct(
        public string $emailSubject,
        public string $body,
        public ?User $user = null,
    ) {
        $this->subject = $this->emailSubject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.custom',
            with: [
                'subject' => $this->emailSubject,
                'appName' => config('app.name'),
                'body' => $this->body,
                'user' => $this->user,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
