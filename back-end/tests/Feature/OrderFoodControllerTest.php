<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderFoodControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $order;
    protected $food;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a customer user
        $this->customer = User::factory()->create();

        // Create an order for the customer
        $this->order = Order::factory()->create([
            'customer_id' => $this->customer->id,
        ]);

        // Create a food item
        $this->food = Food::factory()->create();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');

    }

    /** @test */
    public function test_it_lists_foods_in_an_order()
    {
        // Attach a food item to the order
        $this->order->foods()->attach($this->food->id, ['number' => 2]);

        // Make a GET request to the index endpoint
        $response = $this->getJson("/api/orders/{$this->order->id}/foods");

        // Assert the response
        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'price',
                    'number',
                    'pivot' => [
                        'number',
                    ],
                ],
            ]);
    }

    /** @test */
    public function test_it_adds_a_food_item_to_an_order()
    {
        // Make a POST request to the store endpoint
        $response = $this->postJson("/api/orders/{$this->order->id}/foods", [
            'food_id' => $this->food->id,
            'number' => 3,
        ]);

        // Assert the response
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Food added to order successfully',
                'data' => [
                    'id' => $this->food->id,
                    'name' => $this->food->name,
                    'price' => $this->food->price,
                    'pivot' => [
                        'number' => 3,
                    ],
                ],
            ]);

        // Assert the food is attached to the order
        $this->assertDatabaseHas('orders_foods', [
            'order_id' => $this->order->id,
            'food_id' => $this->food->id,
            'number' => 3,
        ]);
    }

    /** @test */
    public function test_it_shows_a_specific_food_item_in_an_order()
    {
        // Attach a food item to the order
        $this->order->foods()->attach($this->food->id, ['number' => 2]);

        // Make a GET request to the show endpoint
        $response = $this->getJson("/api/orders/{$this->order->id}/foods/{$this->food->id}");

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'id' => $this->food->id,
                'name' => $this->food->name,
                'price' => $this->food->price,
                'pivot' => [
                    'number' => 2,
                ],
            ]);
    }

    /** @test */
    public function test_it_returns_404_if_food_not_found_in_order()
    {
        // Make a GET request to the show endpoint with a non-existent food ID
        $response = $this->getJson("/api/orders/{$this->order->id}/foods/999");

        // Assert the response
        $response->assertStatus(404);
    }

    /** @test */
    public function test_it_updates_the_number_of_a_food_item_in_an_order()
    {
        // Attach a food item to the order
        $this->order->foods()->attach($this->food->id, ['number' => 2]);

        // Make a PUT request to the update endpoint
        $response = $this->putJson("/api/orders/{$this->order->id}/foods/{$this->food->id}", [
            'number' => 5,
        ]);

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Food item updated successfully',
                'data' => [
                    'pivot' => [
                        'number' => 5,
                    ],
                ],
            ]);

        // Assert the pivot table is updated
        $this->assertDatabaseHas('orders_foods', [
            'order_id' => $this->order->id,
            'food_id' => $this->food->id,
            'number' => 5,
        ]);
    }

    /** @test */
    public function test_it_removes_a_food_item_from_an_order()
    {
        // Attach a food item to the order
        $this->order->foods()->attach($this->food->id, ['number' => 2]);

        // Make a DELETE request to the destroy endpoint
        $response = $this->deleteJson("/api/orders/{$this->order->id}/foods/{$this->food->id}");

        // Assert the response
        $response->assertStatus(204);

        // Assert the food is detached from the order
        $this->assertDatabaseMissing('orders_foods', [
            'order_id' => $this->order->id,
            'food_id' => $this->food->id,
        ]);
    }
}