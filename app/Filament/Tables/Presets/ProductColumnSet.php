<?php

namespace App\Filament\Tables\Presets;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\CommonColumns;
use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\PriceColumn;
use App\Filament\Tables\Columns\ProductColumns;
use App\Filament\Tables\Columns\RelationColumn;
use App\Filament\Tables\Columns\SkuColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ProductColumnSet
{
    public static function make(array $extra = []): array
    {
        return [
            NameColumn::make(),
            SkuColumn::make(),
            PriceColumn::make(),
            ActiveColumn::make(),
            RelationColumn::make('categories.name'),
            ...$extra,
        ];
    }
}
