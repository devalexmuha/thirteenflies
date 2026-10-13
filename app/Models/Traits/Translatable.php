<?php

namespace App\Models\Traits;

use Spatie\Translatable\HasTranslations;

trait Translatable
{
    use HasTranslations;

    public function attributesToArray(): array
    {
        $attributes = parent::attributesToArray();

        foreach ($this->getTranslatableAttributes() as $field) {
            $attributes[$field] = $this->getTranslation($field, app()->getLocale(), false);
        }

        return $attributes;
    }
}
