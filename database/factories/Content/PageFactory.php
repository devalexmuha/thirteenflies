<?php

namespace Database\Factories\Content;

use App\Models\Content\Page;
use Database\Factories\Traits\Seo\FillsPageSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    use FillsPageSeoMeta;

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
