<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Brand;
use Database\Factories\Traits\Seo\FillsBrandSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    use FillsBrandSeoMeta;

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
