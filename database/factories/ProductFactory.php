<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'price' => fake()->numberBetween(100, 1000),
            'stock' => fake()->numberBetween(0, 100),
            'status' => 'unavailable',
            'description' => fake()->text(),
            /*'category' => fake()->word(),*/
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterMaking(function (Product $product) {
            $product->status = $product->stock === 0 ? 'unavailable' : 'available';
        });
    }
}
