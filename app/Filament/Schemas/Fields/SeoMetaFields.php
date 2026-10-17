<?php

namespace App\Filament\Schemas\Fields;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;

class SeoMetaFields
{
    public static function metaTitle(): TextInput
    {
        return TextInput::make('meta_title');
    }

    public static function metaDescription(): Group
    {
        return Group::make()
                    ->relationship('seoMeta')
                    ->schema([
                        TextInput::make('meta_description'),
                    ]);
    }

    public static function robots(): Group
    {
        return Group::make()
                    ->relationship('seoMeta')
                    ->schema([
                        Select::make('robots')
                              ->options([
                                  'index, follow'     => 'index, follow',
                                  'noindex, follow'   => 'noindex, follow',
                                  'noindex, nofollow' => 'noindex, nofollow',
                              ])
                              ->default('index, follow')
                              ->selectablePlaceholder(false),
                    ]);
    }
}
