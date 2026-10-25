<?php

namespace Database\Seeders;

use App\Enums\PageTemplate;
use App\Models\Content\Page;
use Database\Factories\Data\Names\PageNames;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * First the pages of the page templates (home and listings, with the template's fixed slug),
     * then the single pages every shop has.
     */
    public function run(): void
    {
        foreach (PageNames::templates() as $template => $localeNames) {
            $this->createPage($localeNames, PageTemplate::from($template));
        }

        foreach (PageNames::get() as $localeNames) {
            $this->createPage($localeNames, PageTemplate::Single);
        }
    }

    /**
     * @param  array<string, string>  $localeNames  locale => name
     */
    private function createPage(array $localeNames, PageTemplate $template): void
    {
        $page = Page::factory()->create([
            'template' => $template,
            'name' => $localeNames,
            'content' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 500, 1000),
        ]);

        $page->seoMeta()->updateOrCreate([], ['h1' => $localeNames]);

        foreach ($localeNames as $locale => $localeName) {
            $page->slugs()->create(['locale' => $locale, 'slug' => $template->slug() ?? $localeName]);
        }
    }
}
