<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory()->count(20)->recycle(User::factory()->count(5)->create())->create();

        $user = User::factory()->hasProducts(4)->unverified()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user->products()->create([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10000,
            'stock' => 0,
            'status' => 'unavailable',
            'category' => 'test',
        ]);
    }
}
