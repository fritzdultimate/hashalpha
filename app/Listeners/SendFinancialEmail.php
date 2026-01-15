<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendFinancialEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void {
        \Log::error('SendFinancial Listener ', [
                'event' => $event,
                'exist' => method_exists($event, 'deposit')
        ]);
        if (method_exists($event, 'deposit')) {
            $this->sendDepositMail($event->deposit);
        }

        if (method_exists($event, 'stake')) {
            $this->sendStakeMail($event->stake);
        }

        if (method_exists($event, 'withdrawal')) {
            $this->sendWithdrawalMail($event->withdrawal);
        }
    }

    protected function sendDepositMail($deposit) {
        Mail::to($deposit->user->email)
            ->send(new \App\Mail\DepositCreatedMail($deposit));
    }

    protected function sendStakeMail($stake)
    {
        Mail::to($stake->user->email)
            ->send(new \App\Mail\StakeCreatedMail($stake));
    }

    protected function sendWithdrawalMail($withdrawal)
    {
        Mail::to($withdrawal->user->email)
            ->send(new \App\Mail\WithdrawalRequestedMail($withdrawal));
    }
}
