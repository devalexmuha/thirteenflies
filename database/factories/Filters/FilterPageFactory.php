<?php

namespace Database\Factories\Filters;

use App\Models\Filters\FilterPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FilterPage>
 */
class FilterPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => true,
        ];
    }
}
