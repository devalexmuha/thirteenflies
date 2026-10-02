<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                         ->required()
                         ->formatStateUsing(fn($record) => $record?->getTranslation('name', app()->getLocale())),
                Toggle::make('is_active')
                      ->default(true),
            ]);
    }
}

// check what is simple resource, move on (check how to enable slug, seo meta, media in this form)
