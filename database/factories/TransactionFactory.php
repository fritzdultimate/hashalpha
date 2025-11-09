<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $types = ['credit', 'debit', 'hold', 'release', 'fee'];
        $type = $this->faker->randomElement($types);
        $amount = $this->faker->numberBetween(100, 500000);
        return [
            'user_id' => User::factory(),
            'type' => $type,
            'amount' => $amount,
            'amount_usd_cents' => $this->faker->optional()->numberBetween(100, 200000),
            'balance_after' => 0,
            'related_type' => $this->faker->optional(0.6)->randomElement(['App\\Models\\Deposit','App\\Models\\Payout','App\\Models\\Stake','App\\Models\\Affiliate']),
            'related_id' => $this->faker->optional()->numberBetween(1, 200),
            'meta' => null,
        ];
    }

    public function credit() {
        return $this->state(fn(array $attributes) => ['type' => 'credit']);
    }

    public function debit() {
        return $this->state(fn(array $attributes) => ['type' => 'debit']);
    }
}
