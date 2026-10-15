<?php

namespace App\Models\Traits;

use App\Support\ContentLocale;
use Spatie\Translatable\HasTranslations;

trait Translatable
{
    use HasTranslations;

    public function getLocale(): string
    {
        return ContentLocale::get();
    }

    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, $this->getLocale(), false);
        }

        return $attributes;
    }
}
