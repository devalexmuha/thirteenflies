<?php

namespace Database\Seeders;

use App\Models\Content\Article;
use App\Models\Content\Author;
use Database\Factories\Data\Names\ArticleNames;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * One article per name in ArticleNames, with a random author, texts, slugs and the name as h1.
     */
    public function run(): void
    {
        $authors = Author::all();

        foreach (ArticleNames::get() as $localeNames) {
            $article = Article::factory()->create([
                'author_id' => $authors->random()->id,
                'name' => $localeNames,
                'excerpt' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 100, 250),
                'content' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 800, 1300),
            ]);

            $article->seoMeta()->updateOrCreate([], ['h1' => $localeNames]);

            foreach ($localeNames as $locale => $localeName) {
                $article->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }
        }
    }
}
