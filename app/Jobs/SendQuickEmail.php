<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQuickEmail implements ShouldQueue {
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public function __construct(
        public array $emails,
        public string $subject,
        public string $content
    ) {}

    public function handle(): void {
        dd($this->emails);
        foreach ($this->emails as $email) {
            Mail::raw($this->content, function ($message) use ($email) {
                $message->to($email)
                        ->subject($this->subject);
            });
        }
    }
}
