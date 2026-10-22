<?php

namespace App\Filament\Tables\Presets;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\PriceColumn;
use App\Filament\Tables\Columns\PriceInputColumn;
use App\Filament\Tables\Columns\RelationColumn;
use App\Filament\Tables\Columns\SkuColumn;
use Filament\Tables\Columns\TextColumn;

class ProductColumnSet
{
    public static function make(array $extra = [], ?TextColumn $name = null): array
    {
        return [
            $name ?? NameColumn::make(),
            SkuColumn::make(),
            PriceColumn::make(),
            ActiveColumn::make(),
            RelationColumn::make('categories.name'),
            ...$extra,
        ];
    }
}
