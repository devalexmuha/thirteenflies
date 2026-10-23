<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Promotion;
use Database\Factories\Traits\Seo\FillsPromotionSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    use FillsPromotionSeoMeta;

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
