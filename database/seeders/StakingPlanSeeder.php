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
            'name' => 'Executive',
            'description' => 'for big boys',
            'min_amount' => 500,
            'max_amount' => 50000,
            'daily_roi' => 10,
            'rules' => 'lockup_days'
        ]);

        $tx->save();

        $this->command->info('Staking plans seeded.');
    }

}
