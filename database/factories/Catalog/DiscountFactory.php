<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Discount;
use Database\Factories\Traits\Seo\FillsDiscountSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Discount>
 */
class DiscountFactory extends Factory
{
    use FillsDiscountSeoMeta;

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
