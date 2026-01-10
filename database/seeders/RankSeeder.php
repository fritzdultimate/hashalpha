<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            ['Amateur', 1, 1_000, 3, 50],
            ['Leader', 2, 5_000, 5, 200],
            ['Bronze', 3, 20_000, 10, 500],
            ['Emerald', 4, 50_000, 20, 1_500],
            ['Silver', 5, 100_000, 30, 3_000],
            ['Ruby', 6, 250_000, 50, 7_500],
            ['Platinum', 7, 500_000, 75, 15_000],
            ['Titanium', 8, 1_000_000, 100, 30_000],
            ['Sapphire', 9, 2_500_000, 150, 75_000],
            ['Rosegold', 10, 5_000_000, 200, 150_000],
            ['Gold', 11, 10_000_000, 300, 300_000],
            ['Diamond', 12, 25_000_000, 500, 750_000],
        ];

        foreach ($levels as [$name, $level, $vol, $refs, $earn]) {
            Rank::create([
                'name' => $name,
                'level' => $level,
                'required_volume' => $vol,
                'required_active_referrals' => $refs,
                'required_earnings' => $earn,
            ]);
        }
        $this->command->info('✅ 12 ranks seeded successfully!');
    }
}
