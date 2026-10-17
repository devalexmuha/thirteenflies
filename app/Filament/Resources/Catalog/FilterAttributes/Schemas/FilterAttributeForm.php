<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FilterAttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter attribute')
                       ->schema([
                           TextInput::make('name')->required(),
                           TextInput::make('slug')
                                    ->required()
                                    ->helperText('Slug stays same for all languages, used in filter URLs.'),
                       ])
                       ->columnSpanFull(),
            ]);
    }
}
