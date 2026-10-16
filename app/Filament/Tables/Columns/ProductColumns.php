<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ProductColumns
{
    public static function get(array $extra = []): array
    {
        return [
            TextColumn::make('name')
                      ->sortable()
                      ->searchable(query: fn(Builder $query, string $search) => $query
                          ->whereRaw('LOWER(CAST(name AS CHAR)) LIKE ?', ['%'.mb_strtolower($search).'%'])),
            TextColumn::make('sku')
                      ->sortable()
                      ->searchable(),
            TextColumn::make('price')
                      ->sortable()
                      ->money('USD'),
            IconColumn::make('is_active')
                      ->boolean()
                      ->sortable()
                      ->toggleable(),
            TextColumn::make('categories.name')
                      ->badge()
                      ->sortable(),
            ...$extra,
        ];
    }
}
