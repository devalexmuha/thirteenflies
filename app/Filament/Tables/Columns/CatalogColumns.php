<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class CatalogColumns
{
    public static function get(array $extra = []): array
    {
        return [
            TextColumn::make('name')
                      ->sortable()
                      ->searchable(),
            IconColumn::make('is_active')
                      ->boolean()
                      ->sortable(),
            TextColumn::make('products_count')
                      ->label('Products')
                      ->counts('products')
                      ->sortable(),
            ...$extra,
        ];
    }
}
