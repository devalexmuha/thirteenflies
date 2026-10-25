<?php

namespace Database\Factories\Support;

use App\Enums\Locale;
use App\Models\Filters\Attribute;
use Database\Factories\Data\AttributeValues\AttributeTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Gives a model (Category or Brand, anything with HasFilterAttributes) its filter attributes and values.
 * Attributes and values are matched by slug of the English text: found ones are reused (and get any new
 * values), missing ones are created in every locale.
 */
class AttributeAssigner
{
    /**
     * @param  array<string, list<string>>  $attributes  English attribute name => English values
     */
    public static function assign(Model $model, array $attributes): void
    {
        $ids = [];

        foreach ($attributes as $attributeName => $values) {
            $attribute = Attribute::firstOrCreate(
                ['slug' => Str::slug($attributeName)],
                ['name' => self::translate($attributeName)],
            );

            foreach ($values as $value) {
                $attribute->values()->firstOrCreate(
                    ['slug' => Str::slug($value)],
                    ['value' => self::translate($value)],
                );
            }

            $ids[] = $attribute->id;
        }

        $model->filterAttributes()->syncWithoutDetaching($ids);
    }

    /**
     * Locale => text; texts without a translation (numbers, codes, model names) are the same everywhere.
     *
     * @return array<string, string>
     */
    private static function translate(string $text): array
    {
        $translations = AttributeTranslations::get()[$text] ?? [];

        $result = [];

        foreach (Locale::cases() as $locale) {
            $result[$locale->value] = $locale->value === 'en' ? $text : $translations[$locale->value] ?? $text;
        }

        return $result;
    }
}
