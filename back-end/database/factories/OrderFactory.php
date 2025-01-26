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
            'status' => $this->faker->randomElement([0, 1, 2, 3]),
            'duration' => $this->faker->numberBetween(30, 180), // Minutes
            'customer_id' => User::factory(),
            'note' => $this->faker->text(),
        ];
    }
}
