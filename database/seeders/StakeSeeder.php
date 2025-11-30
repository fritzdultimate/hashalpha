<?php

namespace Database\Seeders;

use App\Models\Stake;
use App\Models\StakingPlan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!app()->environment(['local', 'testing', 'development'])) {
            $this->command->info('Skipping in non-dev environment.');
            return;
        }

        $tx = Stake::factory()->make([
            'plan_id' => 3,
            'user_id' => 1,
            'amount' => 500,
            'started_at' => now(),
            'wallet_id' => 1
        ]);

        $tx->save();

        $this->command->info('Stake seeded.');
    }

}
