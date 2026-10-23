<?php

namespace Database\Factories\Filters;

use App\Models\Filters\FilterPage;
use Database\Factories\Traits\Seo\FillsFilterPageSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FilterPage>
 */
class FilterPageFactory extends Factory
{
    use FillsFilterPageSeoMeta;

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
