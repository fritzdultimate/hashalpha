<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    public function run(): void {
        DB::table('rewards')->insert([
            [
                'stake_id' => 1,
                'user_id' => 1,
                'amount' => 5,
                'level' => 1,
                'source_user_id' => 1,
                'credited_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'reward_type' => 'staking'
            ],
            [
                'stake_id' => 1,
                'user_id' => 1,
                'amount' => 15,
                'level' => 1,
                'source_user_id' => 1,
                'credited_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
                'reward_type' => 'staking'
            ],
        ]);
    }
}
