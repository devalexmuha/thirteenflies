<?php

namespace App\Filament\Tables\Presets;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\CommonColumns;
use App\Filament\Tables\Columns\CountColumn;
use App\Filament\Tables\Columns\NameColumn;

class CatalogColumnSet
{
    public static function get(array $extra = []): array
    {
        return [
            NameColumn::make(),
            ActiveColumn::make(),
            CountColumn::make('products_count'),
            ...$extra,
        ];
    }
}
