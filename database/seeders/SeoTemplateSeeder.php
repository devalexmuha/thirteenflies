<?php

namespace Database\Seeders;

use App\Enums\SeoTemplateType;
use App\Models\Seo\SeoTemplate;
use Database\Factories\Data\Seo\SeoTemplates;
use Illuminate\Database\Seeder;

class SeoTemplateSeeder extends Seeder
{
    /**
     * One template per SeoTemplateType, filled from SeoTemplates.
     */
    public function run(): void
    {
        foreach (SeoTemplateType::cases() as $type) {
            $template = SeoTemplates::get()[$type->value];

            SeoTemplate::factory()->create([
                'page_type' => $type,
                'meta_title' => $template['title'],
                'meta_description' => $template['description'],
                'h1' => $template['h1'],
                'alt' => $template['alt'],
            ]);
        }
    }
}
