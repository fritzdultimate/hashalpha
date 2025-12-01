<?php
namespace App\Observers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class TransactionObserver {
    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void {
        if ($model instanceof Transaction) {
            return;
        }

        $changed = $model->getChanges();
        if (empty($changed)) {
            return;
        }

        $name = strtolower(class_basename($model));

        $mapping = [
            'stake' => 'hold',
            'stakes' => 'hold',
            'withdraw' => 'debit',
            'withdrawal' => 'debit',
            'withdrawals' => 'debit',
            'deposit' => 'credit',
            'deposits' => 'credit',
            'reward' => 'credit',
            'rewards' => 'credit',
            'payout' => 'credit',
            'transfer' => 'transfer',
            'payment' => 'payment',
            'order' => 'order_update',
        ];
        $type = $mapping[$name];


        
        $payload = [
            'related_type' => get_class($model),
            'related_id' => $model->getKey(),
            'type' => $type,
            
            'amount' => $model->getAttribute('amount') ?: null,
            'user_id' => $model->getAttribute('user_id') ?: null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        
        DB::transaction(function () use ($payload) {
            $tx = Transaction::create($payload);
            $tx->balance_after = User::find($tx->user_id)->balance;
            $tx->save();
        });
    }
}
