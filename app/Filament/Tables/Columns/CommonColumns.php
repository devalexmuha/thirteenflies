<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class CommonColumns
{
    public static function name(): TextColumn
    {
        return TextColumn::make('name')
                         ->sortable()
                         ->searchable(query: fn (Builder $query, string $search) => $query
                             ->whereRaw('LOWER(CAST(name AS CHAR)) LIKE ?', ['%' . mb_strtolower($search) . '%']));
    }

    public static function isActive(string $label = 'Active'): IconColumn
    {
        return IconColumn::make('is_active')->label($label)->boolean()->sortable();
    }

    public static function count(string $relationship): TextColumn
    {
        return TextColumn::make("{$relationship}_count")
                         ->counts($relationship)
                         ->label(Str::headline($relationship))
                         ->sortable();
    }

    public static function relationship(string $relationshipName): TextColumn
    {
        return TextColumn::make($relationshipName)
                         ->limitList(2)
                         ->badge();
    }

    public static function updatedAt(): TextColumn
    {
        return TextColumn::make('updated_at')->dateTime('d.m.Y')->sortable();
    }

}
