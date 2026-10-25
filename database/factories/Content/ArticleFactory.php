<?php

namespace Database\Factories\Content;

use App\Models\Content\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => true,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
