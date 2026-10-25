<?php

namespace Database\Seeders;

use App\Enums\Locale;
use App\Models\Content\Author;
use Database\Factories\Data\Names\AuthorPositions;
use Database\Factories\Data\Sentences\ContentSentences;
use Database\Factories\Support\TextBuilder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuthorSeeder extends Seeder
{
    /**
     * Profile link bases by SocialNetwork value; the author's handle is added to the end.
     */
    private const SOCIAL_LINKS = [
        'instagram' => 'https://www.instagram.com/',
        'youtube' => 'https://www.youtube.com/@',
        'x' => 'https://x.com/',
        'facebook' => 'https://www.facebook.com/',
    ];

    /**
     * Three authors with a position, bios, 2-3 social links and slugs.
     */
    public function run(): void
    {
        Author::factory()->count(3)->create()->each(function (Author $author): void {
            $localeNames = array_fill_keys(array_column(Locale::cases(), 'value'), $author->name);

            $author->update([
                'position' => fake()->randomElement(AuthorPositions::get()),
                'short_bio' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 100, 200),
                'bio' => TextBuilder::forLocales(ContentSentences::get(), $localeNames, 500, 900),
                'socials' => $this->socials($author->name),
            ]);

            foreach ($localeNames as $locale => $localeName) {
                $author->slugs()->create(['locale' => $locale, 'slug' => $localeName]);
            }
        });
    }

    /**
     * @return list<array{network: string, url: string}>
     */
    private function socials(string $name): array
    {
        $networks = fake()->randomElements(array_keys(self::SOCIAL_LINKS), fake()->numberBetween(2, 3));

        return array_map(
            fn (string $network): array => ['network' => $network, 'url' => self::SOCIAL_LINKS[$network].Str::slug($name, '')],
            $networks,
        );
    }
}
