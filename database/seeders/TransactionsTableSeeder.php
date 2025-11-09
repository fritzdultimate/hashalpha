<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!app()->environment(['local', 'testing', 'development'])) {
            $this->command->info('Skipping TransactionsTableSeeder in non-dev environment.');
            return;
        }
        // User::factory()->count(7)->create();

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                DB::transaction(function () use ($user) {
                    $runningBalance = rand(0, 2_000_00);

                    $txCount = rand(8, 25);

                    for ($i = 0; $i < $txCount; $i++) {
                        // choose a type with some realistic probabilities
                        $type = $this->weightedType();

                        
                        $amount = rand(100, 200_000);

                        if (in_array($type, ['credit', 'release'])) {
                            $runningBalance += $amount;
                        } elseif (in_array($type, ['debit', 'fee'])) {
                            $runningBalance = max(0, $runningBalance - $amount);
                        } elseif ($type === 'hold') {
                            $runningBalance = max(0, $runningBalance - $amount);
                        }

                        $tx = Transaction::factory()->make([
                            'user_id' => $user->id,
                            'type' => $type,
                            'amount' => $amount,
                            'amount_usd_cents' => rand(100, 20_000),
                            'balance_after' => $runningBalance,
                            'meta' => [
                                'note' => 'Seeded transaction',
                                'seed_iteration' => $i
                            ],
                        ]);

                        $tx->save();
                    }
                });
            }
        });

        $this->command->info('Transactions seeded.');
    }

    protected function weightedType() {
        $pool = array_merge(
            array_fill(0, 50, 'credit'),
            array_fill(0, 30, 'debit'),
            array_fill(0, 8, 'fee'),
            array_fill(0, 7, 'hold'),
            array_fill(0, 5, 'release'),
        );
        return $pool[array_rand($pool)];
    }
}
