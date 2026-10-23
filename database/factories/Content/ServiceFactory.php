<?php

namespace Database\Factories\Content;

use App\Models\Content\Service;
use Database\Factories\Traits\Seo\FillsServiceSeoMeta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    use FillsServiceSeoMeta;

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
