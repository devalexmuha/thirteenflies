<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Category;
use Database\Factories\Data\Catalog\CategoryNames;
use Database\Factories\Traits\Seo\FillsCategorySeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    use FillsCategorySeoMeta;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(CategoryNames::get()),
            'is_active' => true,
        ];
    }
}
