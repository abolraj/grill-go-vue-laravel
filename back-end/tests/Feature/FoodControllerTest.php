<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FoodControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public'); // Use fake storage for testing

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function test_it_stores_a_food_item_with_image()
    {
        $file = UploadedFile::fake()->image('food.jpg');

        $response = $this->postJson('/api/foods', [
            'name' => 'Pizza',
            'price' => 1000,
            'number' => 10,
            'category' => 'Fast Food',
            'image' => $file,
            'ingredients' => 'Cheese, Tomato, Dough',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'name',
                'price',
                'number',
                'category',
                'image_path',
                'ingredients',
            ]);

        // Assert the image was stored
        $food = Food::first();
        Storage::disk('public')->assertExists($food->image_path);
    }

    /** @test */
    public function test_it_updates_a_food_item_with_new_image()
    {
        $food = Food::factory()->create(['image_path' => 'images/old.jpg']);
        Storage::disk('public')->put('images/old.jpg', 'dummy content');

        $file = UploadedFile::fake()->image('new_food.jpg');

        $response = $this->putJson("/api/foods/{$food->id}", [
            'name' => 'Updated Pizza',
            'image' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Pizza',
            ]);

        // Assert the old image was deleted
        Storage::disk('public')->assertMissing('images/old.jpg');

        // Assert the new image was stored
        $food->refresh();
        Storage::disk('public')->assertExists($food->image_path);
    }

    /** @test */
    public function test_it_deletes_a_food_item_and_its_image()
    {
        $food = Food::factory()->create(['image_path' => 'images/food.jpg']);
        Storage::disk('public')->put('images/food.jpg', 'dummy content');

        $response = $this->deleteJson("/api/foods/{$food->id}");

        $response->assertStatus(204);

        // Assert the food item was deleted
        $this->assertDatabaseMissing('foods', ['id' => $food->id]);

        // Assert the image was deleted
        Storage::disk('public')->assertMissing('images/food.jpg');
    }
}