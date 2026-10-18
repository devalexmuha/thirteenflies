<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Schemas;

use App\Filament\Forms\Fields\TextFields\NameInput;
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
                           NameInput::make(),
                           TextInput::make('slug')
                                    ->required()
                                    ->helperText('Slug stays same for all languages, used in filter URLs.'),
                       ])
                       ->columnSpanFull(),
            ]);
    }
}
