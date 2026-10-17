<?php

namespace App\Filament\Tables\Filters;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;

class ProductFilters
{
    public static function get(array $extra = []): array
    {
        return [
            SelectFilter::make('categories')
                        ->relationship('categories', 'name')
                        ->multiple()
                        ->preload(),
            SelectFilter::make('brand')
                        ->relationship('brand', 'name')
                        ->preload(),
            Filter::make('price')
                  ->schema([
                      Grid::make(2)->schema([
                          TextInput::make('from')->numeric()->prefix('$'),
                          TextInput::make('to')->numeric()->prefix('$'),
                      ]),
                  ])
                  ->query(fn(Builder $query, array $data) => $query
                      ->when($data['from'], fn(Builder $q, $v) => $q->where('price', '>=', $v))
                      ->when($data['to'], fn(Builder $q, $v) => $q->where('price', '<=', $v))),
            TernaryFilter::make('is_active')->label('Active'),
            ...$extra,
        ];
    }
}
