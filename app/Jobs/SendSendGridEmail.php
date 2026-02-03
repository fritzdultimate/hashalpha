<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SendGrid\Mail\Mail;

class SendSendGridEmail implements ShouldQueue {
    use Queueable, InteractsWithQueue, SerializesModels;
    public function __construct(
        public string $templateId,
        public string $email
    ) {}

    public function handle(): void {
        $mail = new Mail();

        $mail->setFrom(
            config('services.sendgrid.from_email'),
            config('services.sendgrid.from_name')
        );

        $mail->addTo($this->email);
        $mail->setTemplateId($this->templateId);

        $sg = new \SendGrid(config('services.sendgrid.api_key'));
        $sg->send($mail);
    }
}
