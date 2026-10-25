<?php

namespace Database\Factories\Content;

use App\Enums\PageTemplate;
use App\Models\Content\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'template' => PageTemplate::Single,
            'is_active' => true,
            'published_at' => now(),
        ];
    }
}
