<?php

namespace Database\Factories\Support;

/**
 * Builds the HTML for rich-editor fields (SEO texts, descriptions, article content) out of a sentence bank.
 */
class TextBuilder
{
    /**
     * One text per locale of $sentences, with {name} replaced by the model's name in that locale
     * (falls back to the first name given). Each text gets its own random length between $min and $max.
     *
     * @param  array<string, list<string>>  $sentences  locale => sentences, e.g. CatalogSentences::get()
     * @param  array<string, string>  $localeNames  locale => name, e.g. $model->getTranslations('name')
     * @return array<string, string> locale => HTML
     */
    public static function forLocales(array $sentences, array $localeNames, int $min, int $max): array
    {
        $texts = [];

        foreach ($sentences as $locale => $localeSentences) {
            $name = $localeNames[$locale];

            $filled = array_map(
                fn (string $sentence): string => strtr($sentence, ['{name}' => $name]),
                $localeSentences,
            );

            $texts[$locale] = static::make($filled, fake()->numberBetween($min, $max));
        }

        return $texts;
    }

    /**
     * Random sentences up to (not over) $limit characters, as the HTML the rich editors store:
     * one <p> per 3 sentences.
     *
     * @param  list<string>  $sentences
     */
    public static function make(array $sentences, int $limit): string
    {
        $text = '';
        $picked = [];

        foreach (fake()->shuffle($sentences) as $sentence) {
            if (mb_strlen("{$text} {$sentence}") <= $limit) {
                $text = trim("{$text} {$sentence}");
                $picked[] = $sentence;
            }
        }

        return collect($picked)
            ->chunk(3)
            ->map(fn ($paragraph): string => '<p>'.$paragraph->implode(' ').'</p>')
            ->implode('');
    }
}
