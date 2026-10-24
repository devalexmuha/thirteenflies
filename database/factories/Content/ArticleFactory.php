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
            'name' => ['en' => ucfirst(fake()->words(4, true))],
            'is_active' => true,
            'published_at' => now(),
        ];
    }
}
