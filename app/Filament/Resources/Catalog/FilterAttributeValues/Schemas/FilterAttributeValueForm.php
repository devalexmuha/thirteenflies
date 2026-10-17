<?php

namespace App\Filament\Resources\Catalog\FilterAttributeValues\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FilterAttributeValueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter value')
                       ->schema([
                           TextInput::make('value')->required(),
                           TextInput::make('slug')
                                    ->required()
                                    ->helperText('Slug stays same for all languages, used in filter URLs.'),
                       ])
                       ->columnSpanFull(),
            ]);
    }
}
