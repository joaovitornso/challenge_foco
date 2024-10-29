<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use App\Models\Reserve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reserve_id' => Reserve::factory(),
            'method_id' => PaymentMethod::factory(),
            'value' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
