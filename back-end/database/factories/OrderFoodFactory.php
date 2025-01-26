<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Food;
use App\Models\Order;

class OrderFoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(1, 10), // Random number of food items (1 to 10)
            'food_id' => Food::pluck('id')->random(), // Random food ID
            'order_id' => Order::pluck('id')->random(), // Random order ID
        ];
    }
}