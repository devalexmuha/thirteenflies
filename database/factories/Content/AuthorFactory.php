<?php

namespace Database\Factories\Content;

use App\Models\Content\Author;
use Database\Factories\Traits\Seo\FillsAuthorSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    use FillsAuthorSeoMeta;

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
