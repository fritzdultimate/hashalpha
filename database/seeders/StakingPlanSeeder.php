<?php

namespace Database\Seeders;

use App\Models\StakingPlan;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StakingPlanSeeder extends Seeder
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

        $tx = StakingPlan::factory()->make([
            'name' => 'Standard',
            'description' => 'for users with unsolidified experience in investment...',
            'min_amount' => 200,
            'max_amount' => 1000,
            'daily_roi' => 7,
            'rules' => 'lockup_days'
        ]);

        $tx->save();

        $this->command->info('Staking plans seeded.');
    }

}
