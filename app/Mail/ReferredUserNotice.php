<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReferredUserNotice extends Mailable {
    use Queueable, SerializesModels;

    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public User $referrer, 
        public User $referredUser, 
        public int $level
    ) {
        $this->subject = '🎉 New Referral Joined Your Network';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: $this->subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.user.referred-user-notice',
            with: [
                'referrer' => $this->referrer,
                'user'     => $this->referredUser,
                'level'    => $this->level,
                'subject' => $this->subject 
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
