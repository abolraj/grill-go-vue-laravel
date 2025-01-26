<?php

namespace Database\Factories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($this->faker));
        return [
            'name' => $this->faker->foodName(),
            'price' => fake()->numberBetween(10_000,1_000_000),
            'number' => fake()->numberBetween(0,40),
            'category' => $this->faker->foodName(),
            'image_path' => fake()->imageUrl(),
            'ingredients' => fake()->text(),
        ];
    }
}
