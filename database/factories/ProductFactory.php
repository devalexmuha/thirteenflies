<?php

namespace Database\Factories;

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
        $stock = fake()->numberBetween(0, 10);

        return [
            'sku'         => fake()->unique()->bothify('TF-#####'),
            'name'        => ['en' => 'Guitar ' . ucfirst(fake()->word())],
            'description' => ['en' => fake()->paragraph()],
            'price'       => fake()->numberBetween(10_000, 200_000),
            'stock_qty'   => $stock,
            'in_stock'    => $stock > 0,
        ];
    }
}
