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
            'name' => 'Legend',
            'description' => 'for vip who have solid experience in crypto market.',
            'min_amount' => 10000,
            'max_amount' => 900001,
            'daily_roi' => 60,
            'rules' => 'lockup_days'
        ]);

        $tx->save();

        $this->command->info('Staking plans seeded.');
    }

}
