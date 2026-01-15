<?php

namespace App\Listeners;

use App\Events\DepositCreated;
use App\Events\StakeCreated;
use App\Events\WithdrawalRequested;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendFinancialEmail
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
        Log::info('SendFinancialEmail fired', [
            'event' => get_class($event),
            'props' => get_object_vars($event),
            'instance' => $event instanceof DepositCreated
        ]);

        if ($event instanceof DepositCreated) {
            $this->sendDepositMail($event->deposit);
            return;
        }

        // if ($event instanceof StakeCreated) {
        //     $this->sendStakeMail($event->stake);
        // }

        // if ($event instanceof WithdrawalRequested) {
        //     $this->sendWithdrawalMail($event->withdrawal);
        // }
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
