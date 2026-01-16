<?php

namespace App\Listeners;

use App\Events\DepositBonusReceived;
use App\Events\DepositCreated;
use App\Events\StakeCreated;
use App\Events\WithdrawalRequested;
use App\Models\Transaction;
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

            $event->deposit->transactions()->create([
                'user_id' => $event->deposit->user_id,
                'type' => 'credit',
                'amount' => $event->deposit->amount,
            ]);

            // $payload = [
            //     'related_type' => get_class($event->deposit),
            //     'related_id' => $event->deposit->getKey(),
            //     'type' => 'credit',
                
            //     'amount' => $event->deposit->amount ?: null,
            //     'user_id' => $event->deposit->user_id ?: null,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ];
            // Transaction::create($payload);
            return;
        }

        if ($event instanceof DepositBonusReceived) {
            $this->sendReceivedBonusMail($event->deposit);
            return;
        }
    }

    protected function sendDepositMail($deposit) {
        Mail::to($deposit->user->email)
            ->send(new \App\Mail\DepositCreatedMail($deposit));
    }

    protected function sendReceivedBonusMail($deposit) {
        Mail::to($deposit->user->email)
            ->send(new \App\Mail\DepositBonusMail($deposit));
    }
}
