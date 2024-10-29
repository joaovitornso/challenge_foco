<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CouponCode>
 */
class CouponCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word,
            'discount_type' => $this->faker->randomElement(['percent', 'fixed']),
            'value' => $this->faker->randomFloat(2, 1, 100), // Valor entre 1 e 100
            'description' => $this->faker->sentence,
            'start_date' => now(),
            'end_date' => now()->addDays($this->faker->numberBetween(1, 30)),
            'max_uses' => $this->faker->numberBetween(1, 10),
            'times_used' => 0,
        ];
    }
}
