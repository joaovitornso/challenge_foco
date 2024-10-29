<?php

namespace Database\Factories;

use App\Models\CouponCode;
use App\Models\Reserve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
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
            'coupon_id' => CouponCode::factory(),
            'discount_type' => $this->faker->randomElement(['percent', 'fixed']),
            'value' => $this->faker->randomFloat(2, 0, 100), 
            'description' => $this->faker->sentence(),
        ];
    }
}
