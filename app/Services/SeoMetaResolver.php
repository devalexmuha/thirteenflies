<?php

namespace App\Services;

use App\Enums\SeoTemplateType;
use App\Models\Seo\SeoMeta;
use App\Models\Seo\SeoTemplate;
use Illuminate\Database\Eloquent\Model;

class SeoMetaResolver
{
    /** Fields filled from the template when the model's own SEO meta has no value. */
    private const TEMPLATED_FIELDS = ['meta_title', 'meta_description', 'h1'];

    /**
     * The model's SEO meta with every blank field filled from the SEO template of its type.
     * The returned instance is a copy and is never saved.
     */
    public function resolve(Model $model): SeoMeta
    {
        $meta = $model->seoMeta ?? new SeoMeta;
        $template = $this->templateFor($model);

        if ($template === null) {
            return $meta;
        }

        foreach (self::TEMPLATED_FIELDS as $field) {
            if (blank($meta->{$field}) && filled($template->{$field})) {
                $meta->{$field} = $this->replacePlaceholders($template->{$field}, $model);
            }
        }

        return $meta;
    }

    private function templateFor(Model $model): ?SeoTemplate
    {
        $type = SeoTemplateType::forModel($model);

        return $type === null ? null : SeoTemplate::where('page_type', $type)->first();
    }

    private function replacePlaceholders(string $text, Model $model, int $count = 1): string
    {
        return strtr($text, [
            '{name}' => (string) $model->name,
        ]);
    }
}
