<?php

namespace Database\Factories\Content;

use App\Models\Content\Article;
use Database\Factories\Traits\Seo\FillsArticleSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    use FillsArticleSeoMeta;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
