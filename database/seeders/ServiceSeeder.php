<?php

namespace Database\Seeders;

use App\Models\Content\Author;
use App\Models\Content\Service;
use Database\Factories\Data\Names\ServiceNames;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * One service per name in ServiceNames, with a random author, texts, slugs and the name as h1.
     */
    public function run(): void
    {
        $authors = Author::all();

        foreach (ServiceNames::get() as $localeNames) {
            $service = Service::factory()->create([
                'author_id' => $authors->random()->id,
                'name' => $localeNames,
                'excerpt' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 100, 250),
                'content' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 800, 1300),
            ]);

            $service->seoMeta()->updateOrCreate([], ['h1' => $localeNames]);

            foreach ($localeNames as $locale => $localeName) {
                $service->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }
        }
    }
}
