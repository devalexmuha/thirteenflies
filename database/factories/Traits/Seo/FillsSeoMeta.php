<?php

namespace Database\Factories\Traits\Seo;

use App\Enums\Locale;
use Illuminate\Database\Eloquent\Model;

/**
 * Base for factories of models using HasSeoMeta: after create, fills the
 * seoMeta row for every locale of the model's name. Per page type traits
 * (e.g. FillsCategorySeoMeta) `use` this one and provide the texts.
 */
trait FillsSeoMeta
{
    /**
     * @return array<string, array{title: string, description: string, h1: string}> locale => templates using {name}
     */
    abstract protected function seoTemplates(): array;

    public function configure(): static
    {
        return $this->afterCreating(function (Model $model): void {
            $this->fillSeoMeta($model);
        });
    }

    protected function fillSeoMeta(Model $model): void
    {
        $data = [];

        foreach ($this->seoLocaleNames($model) as $locale => $name) {
            $templates = $this->seoTemplates()[$locale];

            $data['meta_title'][$locale] = strtr($templates['title'], ['{name}' => $name]);
            $data['meta_description'][$locale] = strtr($templates['description'], ['{name}' => $name]);
            $data['h1'][$locale] = strtr($templates['h1'], ['{name}' => $name]);

            // seoTextSentences() is optional: only traits with top/bottom texts (see Sentences\CatalogSentences) define it.
            if ($sentences = method_exists($this, 'seoTextSentences') ? ($this->seoTextSentences()[$locale] ?? []) : []) {
                $sentences = array_map(fn (string $sentence): string => strtr($sentence, ['{name}' => $name]), $sentences);

                $data['seo_text_top'][$locale] = $this->seoText($sentences, fake()->numberBetween(200, 500));
                $data['seo_text_bottom'][$locale] = $this->seoText($sentences, fake()->numberBetween(900, 1500));
            }
        }

        $model->seoMeta()->updateOrCreate([], $data);
    }

    /**
     * Locale => name. Translatable names give their own locales; a plain string name is used for every locale.
     *
     * @return array<string, string>
     */
    protected function seoLocaleNames(Model $model): array
    {
        if ($model->isTranslatableAttribute('name')) {
            return array_filter($model->getTranslations('name'));
        }

        return array_fill_keys(array_column(Locale::cases(), 'value'), $model->name);
    }

    /**
     * Random sentences joined up to (not over) $limit characters, as the HTML the rich editors store.
     *
     * @param  list<string>  $sentences
     */
    protected function seoText(array $sentences, int $limit): string
    {
        $text = '';

        foreach (fake()->shuffle($sentences) as $sentence) {
            if (mb_strlen("{$text} {$sentence}") <= $limit) {
                $text = trim("{$text} {$sentence}");
            }
        }

        return "<p>{$text}</p>";
    }
}
