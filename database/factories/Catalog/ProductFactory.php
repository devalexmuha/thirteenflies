<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition(): array
    {
        $stock = fake()->numberBetween(0, 119);

        return [
            'sku' => fake()->unique()->bothify('TF-#####'),
            'price' => fake()->numberBetween(1_000, 500_000),
            'stock_qty' => $stock,
            'in_stock' => $stock > 0,
            'is_featured' => fake()->boolean(10),
        ];
    }
}
