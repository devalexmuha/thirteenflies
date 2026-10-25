<?php

namespace Database\Factories\Catalog;

use App\Enums\DiscountType;
use App\Models\Catalog\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(DiscountType::cases())->value,
        ];
    }
}
