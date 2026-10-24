<?php

namespace Database\Factories\Filters;

use App\Models\Filters\FilterPage;
use Database\Factories\Data\Sentences\CatalogSentences;
use Database\Factories\Traits\Seo\FillsSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FilterPage>
 */
class FilterPageFactory extends Factory
{
    use FillsSeoMeta;

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

    public function seoTextSentences(): array
    {
        return CatalogSentences::get();
    }
}
