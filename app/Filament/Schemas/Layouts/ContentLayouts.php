<?php

namespace App\Filament\Schemas\Layouts;


use App\Filament\Forms\Fields\EditorFields\SeoEditor;
use App\Filament\Schemas\Components\RelationGroups;
use App\Filament\Schemas\Fields\ImagePicker;
use App\Filament\Schemas\Fields\SeoFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use InvalidArgumentException;

class ContentLayouts
{
    /**
     * ContentLayouts::make('categories', ['block_1', 'block_2', 'block_3'])
     * Items can be block names (string) or any Filament component.
     */
    public static function make(string $directory, array $blocks): array
    {
        $result = [];

        foreach ($blocks as $block) {
            // Ready-made component → use as is
            if ( ! is_string($block)) {
                $result[] = $block;
                continue;
            }

            if ($block === 'make' || ! method_exists(self::class, $block)) {
                throw new InvalidArgumentException("Unknown content block: {$block}");
            }

            $result[] = self::$block($directory);
        }

        return $result;
    }

    // text fields
    private static function name()
    {
        return TextInput::make('name')->required();
    }

    private static function discountType()
    {
        return TextInput::make('type')->disabled();
    }

    private static function h1()
    {
        return RelationGroups::make('seoMeta', SeoFields::make(['h1']));
    }

    private static function seoContent()
    {
        return RelationGroups::make('seoMeta', [
            ...SeoFields::make(['h1']),
            SeoEditor::make('seo_text_top')->label('Top Description'),
            SeoEditor::make('seo_text_bottom')->label('Bottom Description'),
        ]);
    }

    // product related
    private static function productBasics()
    {
        return Grid::make(2)->schema([
            TextInput::make('name')->required()->columnSpanFull(),
            TextInput::make('sku')->required()->unique(ignoreRecord: true),
            TextInput::make('price')->numeric()->prefix('$')->required(),
        ]);
    }

    private static function shortDescription()
    {
        return SeoEditor::make('short_description')->label('Short Description');
    }

    private static function description()
    {
        return SeoEditor::make('description')->label('Description');
    }

    // pages || post related
    private static function postContent()
    {
        return SeoEditor::make('content');
    }

    // images
    private static function mainBanner(string $directory)
    {
        return ImagePicker::fieldSet(fieldLabel: 'Main Banner', fieldName: 'main_banner',
            relationshipName: 'mainBanner', maxItems: 1, directory: $directory);
    }

    private static function featuredImage(string $directory)
    {
        return ImagePicker::fieldSet(fieldLabel: 'Featured Image', fieldName: 'featured_image',
            relationshipName: 'featuredImage', maxItems: 1, directory: $directory);
    }

    private static function gallery(string $directory)
    {
        return ImagePicker::fieldSet(directory: $directory);
    }
}
