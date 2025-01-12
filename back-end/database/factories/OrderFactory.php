<?php

namespace Database\Factories;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'total_number' => $this->faker->numberBetween(1, 10),
            'total_price' => $this->faker->numberBetween(1000, 100000),
            'status' => $this->faker->randomElement([0, 1, 2, 3]),
            'duration' => $this->faker->numberBetween(30, 180), // Minutes
            'customer_id' => User::factory(),
            'food_id' => Food::factory(),
        ];
    }
}
