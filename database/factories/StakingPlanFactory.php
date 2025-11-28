<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class StakingPlanFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $names = ['Advanced', 'Executives'];
        $name = $this->faker->randomElement($names);
        return [
            'name' => $name,
            'description' => 'for big boys',
            'min_amount' => 50001,
            'max_amount' => 50000,
            'daily_roi' => 15,
            'rules' => 'lockup_days'
        ];
    }
}
