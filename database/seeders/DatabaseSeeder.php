<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Services\AvatarService;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function __construct(
        public AvatarService $avatar
    ) {}

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory()->count(50)
            ->recycle(Category::factory()->count(5)->create())
            ->recycle(User::factory()->count(5)->create())
            ->create();

        $adminUser = User::factory()->hasProducts(4)->unverified()->admin()->create([
            'name' => 'Test Admin',
            'avatar' => $this->avatar->generate('Test Admin'),
            'email' => 'admin@example.com',
        ]);

        $adminUser->products()->create([
            'name' => 'Test Admin Product',
            'description' => 'Test Admin Description',
            'price' => 10000,
            'stock' => 0,
            'status' => 'unavailable',
            'category_id' => fake()->numberBetween(1, 5),
        ]);

        $user = User::factory()->hasProducts(4)->unverified()->create([
            'name' => 'Test User',
            'avatar' => $this->avatar->generate('Test User'),
            'email' => 'test@example.com',
        ]);

        $user->products()->create([
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 10000,
            'stock' => 0,
            'status' => 'unavailable',
            'category_id' => fake()->numberBetween(1, 5),
        ]);
    }
}
