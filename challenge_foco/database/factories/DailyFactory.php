<?php

namespace Database\Factories;

use App\Models\Reserve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Daily>
 */
class DailyFactory extends Factory
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
            'date' => $this->faker->date(),
            'value' => $this->faker->randomFloat(2, 50, 500)
        ];
    }
}


