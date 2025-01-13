<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'username' => 'johndoe',
            'location' => 'New York',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type'
                 ]);
        
        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@example.com',
            'username' => 'johndoe'
        ]);
    }

    public function test_login_with_email()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'johndoe@example.com',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type'
                 ]);
    }

    public function test_login_with_username()
    {
        $user = User::factory()->create([
            'username' => 'johndoe',
            'password' => bcrypt('password123')
        ]);

        $response = $this->postJson('/api/login', [
            'username' => 'johndoe',
            'password' => 'password123'
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'access_token',
                     'token_type'
                 ]);
    }

    public function test_logout()
    {
        $user = User::factory()->create([
            'email' => 'johndoe@example.com',
            'password' => bcrypt('password123')
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Successfully logged out']);
    }
}
