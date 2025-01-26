<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function test_it_can_list_all_orders()
    {
        Order::factory()->count(3)->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function test_it_can_create_an_order()
    {
        $user = User::factory()->create();
        $food = Food::factory()->create();
        $orderData = [
            'status' => 1,
            'duration' => 30,
            'customer_id' => $user->id,
            'note' => 'Add a sauce',
        ];

        $response = $this->postJson('/api/orders', $orderData);

        $response->assertStatus(201)
            ->assertJson($orderData);

        $this->assertDatabaseHas('orders', $orderData);
    }

    /** @test */
    public function test_it_can_show_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->getJson('/api/orders/' . $order->id);

        $response->assertStatus(200)
            ->assertJson($order->toArray());
    }

    /** @test */
    public function test_it_can_update_an_order()
    {
        $order = Order::factory()->create();
        $updatedData = [
            'status' => 2,
            'duration' => 60,
            'note' => 'Add a lemonade'
        ];

        $response = $this->putJson('/api/orders/' . $order->id, $updatedData);

        $response->assertStatus(200)
            ->assertJson($updatedData);

        $this->assertDatabaseHas('orders', $updatedData);
    }

    /** @test */
    public function test_it_can_delete_an_order()
    {
        $order = Order::factory()->create();

        $response = $this->deleteJson('/api/orders/' . $order->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
