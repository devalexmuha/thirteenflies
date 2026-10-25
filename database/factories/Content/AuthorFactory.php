<?php

namespace Database\Factories\Content;

use App\Models\Content\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName().' '.fake()->lastName(),
            'is_active' => true,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
