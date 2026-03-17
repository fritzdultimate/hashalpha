<?php

namespace Database\Seeders;

use App\Models\UnilevelPercentage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnilevelPercentageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $data = [
            1 => 100,
            2 => 60,
            3 => 50,
            4 => 40,
            5 => 30,
            6 => 20,
            7 => 15,
            8 => 10,
            9 => 5,
            10 => 2.5,
        ];

        foreach ($data as $level => $percentage) {
            UnilevelPercentage::updateOrCreate(
                ['level' => $level],
                ['percentage' => $percentage]
            );
        }
    }
}
