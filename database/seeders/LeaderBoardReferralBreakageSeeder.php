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
            2 => 90,
            3 => 80,
            4 => 70,
            5 => 60,
            6 => 50,
            7 => 40,
            8 => 35,
            9 => 30,
            10 => 25,
        ];

        foreach ($levels as $level => $percentage) {
            LeaderboardReferralBreakage::updateOrCreate(
                ['level' => $level],
                ['percentage' => $percentage]
            );
        }
    }
}
