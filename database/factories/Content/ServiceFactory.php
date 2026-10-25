<?php

namespace Database\Factories\Content;

use App\Models\Content\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'price_from' => fake()->numberBetween(30, 400),
            'is_active' => true,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
