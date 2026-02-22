<?php

namespace Database\Seeders;

use App\Models\LeaderboardReferralBreakage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaderBoardReferralBreakageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            1 => 100,
            2 => 50,
            3 => 20,
            4 => 10,
            5 => 5,
            6 => 3,
            7 => 2,
            8 => 1,
            9 => 1,
            10 => 1,
        ];

        foreach ($levels as $level => $percentage) {
            LeaderboardReferralBreakage::updateOrCreate(
                ['level' => $level],
                ['percentage' => $percentage]
            );
        }
    }
}
