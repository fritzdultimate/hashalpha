<?php

namespace App\Jobs;

use App\Mail\AdminCustomMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendQuickEmail implements ShouldQueue {
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public int $tries = 3;

    public int $backoff = 30;

    /**
     * @param  array<int, string>  $emails  Recipient email addresses (platform users and/or arbitrary addresses).
     * @param  string  $subject  Subject line chosen by the admin.
     * @param  string  $content  Sanitized HTML body produced by the admin's rich text editor.
     */
    public function __construct(
        public array $emails,
        public string $subject,
        public string $content
    ) {}

    public function handle(): void {
        // Look up any recipients who are also platform users so the email
        // can be personalised with a greeting, without requiring every
        // recipient to be a registered user.
        $users = User::whereIn('email', $this->emails)
            ->get()
            ->keyBy(fn (User $user) => strtolower($user->email));

        foreach ($this->emails as $email) {
            try {
                $user = $users->get(strtolower($email));

                Mail::to($email)->send(
                    new AdminCustomMail($this->subject, $this->content, $user)
                );
            } catch (\Throwable $e) {
                Log::error('Admin custom email failed to send', [
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
