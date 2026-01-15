<?php

namespace App\Listeners;

use App\Events\DepositBonusReceived;
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
        if ($event instanceof DepositCreated) {
            $this->sendDepositMail($event->deposit);
            return;
        }

        if ($event instanceof DepositBonusReceived) {
            $this->sendReceivedBonusMail($event->deposit);
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

    protected function sendReceivedBonusMail($deposit) {
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
