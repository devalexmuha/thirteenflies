<?php

namespace App\Filament\Schemas\Layouts;

use App\Filament\Schemas\Components\RelationFieldsets;
use App\Filament\Schemas\Components\RelationGroups;
use App\Filament\Schemas\Fields\SeoFields;
use InvalidArgumentException;

class SeoLayouts
{
    /**
     * SeoLayouts::make(['metaTags', 'productMetaTemplates'])
     */
    public static function make(array $blocks): array
    {
        $result = [];

        foreach ($blocks as $block) {
            if ($block === 'make' || ! method_exists(self::class, $block)) {
                throw new InvalidArgumentException("Unknown SEO layout: {$block}");
            }

            $result = [...$result, ...self::$block()];
        }

        return $result;
    }

    private static function metaTags(): array
    {
        return [
            RelationGroups::make('seoMeta', SeoFields::make(['title'])),
            RelationGroups::make('slug', SeoFields::make(['slug'])),
            RelationGroups::make('seoMeta', SeoFields::make(['description', 'robots'])),
        ];
    }

    private static function productMetaTemplates(): array
    {
        return [
            RelationFieldsets::make(
                'Product Meta Template',
                'productMetaTemplates',
                SeoFields::make(['title', 'description']),
            ),
        ];
    }
}
