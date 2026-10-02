<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Tables\CategoriesTable;
use Filament\Forms\Components\ModalTableSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                         ->required()
                         ->formatStateUsing(fn($record) => $record?->getTranslation('name', app()->getLocale())),

                TextInput::make('sku')
                         ->required()
                         ->unique(ignoreRecord: true),

                TextInput::make('price')
                         ->numeric()
                         ->prefix('$')
                         ->required(),

                ModalTableSelect::make('category_id')
                                ->relationship('categories', 'name')
                                ->multiple()
                                ->tableConfiguration(CategoriesTable::class),

                Toggle::make('is_active')
                      ->default(true),
            ]);
    }
}
