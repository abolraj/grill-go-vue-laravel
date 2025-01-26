<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'abol',
            'username' => 'abol_web',
            'email' => 'a@gmail.com',
            'password' => Hash::make('abc123456'),
        ]);

        $this->call([
            FoodSeeder::class,
            OrderSeeder::class,
            OrderFoodSeeder::class,
        ]);
    }
}
