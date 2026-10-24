<?php

namespace Database\Seeders;

use App\Models\Content\Article;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Articles from the factory, with content built from ContentSentences in every locale.
     */
    public function run(): void
    {
        Article::factory()->count(10)->create()->each(function (Article $article): void {
            $article->update([
                'content' => TextBuilder::forLocales(ContentSentences::get(), $article->getTranslations('name'), 800, 1300),
            ]);
        });
    }
}
