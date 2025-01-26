<?php

namespace Database\Seeders;

use App\Models\OrderFood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderFood::factory()
            ->count(100)
            ->create();
    }
}
