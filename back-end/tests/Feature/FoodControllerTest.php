<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Food;
use App\Models\User;

class FoodControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    public function test_index()
    {
        Food::factory()->count(3)->create();

        $response = $this->getJson('/api/foods');

        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_store()
    {
        $foodData = [
            'name' => 'Pizza',
            'price' => 999,
            'number' => 10,
            'parent_id' => null,
        ];

        $response = $this->postJson('/api/foods', $foodData);

        $response->assertStatus(201)
                 ->assertJsonFragment($foodData);

        $this->assertDatabaseHas('foods', $foodData);
    }

    public function test_show()
    {
        $food = Food::factory()->create();

        $response = $this->getJson('/api/foods/' . $food->id);

        $response->assertStatus(200)
                 ->assertJson($food->toArray());
    }

    public function test_update()
    {
        $food = Food::factory()->create();

        $updateData = [
            'name' => 'Updated Pizza',
            'price' => 1099,
            'number' => 15,
            'parent_id' => null,
        ];

        $response = $this->putJson('/api/foods/' . $food->id, $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment($updateData);

        $this->assertDatabaseHas('foods', $updateData);
    }

    public function test_destroy()
    {
        $food = Food::factory()->create();

        $response = $this->deleteJson('/api/foods/' . $food->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('foods', ['id' => $food->id]);
    }
}
