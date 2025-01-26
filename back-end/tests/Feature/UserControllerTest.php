<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
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
        $users = User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
                 ->assertJsonCount(4);
    }

    public function test_show()
    {
        $user = User::factory()->create();

        $response = $this->getJson('/api/users/' . $user->id);

        $response->assertStatus(200)
                 ->assertJson($user->toArray());
    }

    public function test_update()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
            'username' => 'updatedusername',
            'location' => 'Updated Location',
            'role' => 'Manager',
            'avatar' => 2,
            'password' => 'newpassword123',
        ];

        $response = $this->putJson('/api/users/' . $user->id, $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'name' => 'Updated Name',
                     'email' => 'updatedemail@example.com',
                     'username' => 'updatedusername',
                     'location' => 'Updated Location',
                     'role' => 'Manager',
                     'avatar' => 2,         
                 ]);

        // Verify password is hashed
        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
    }

    public function test_destroy()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
