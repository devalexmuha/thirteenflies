<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class ProductColumns
{
    public static function sku(): TextColumn
    {
        return TextColumn::make('sku')
                         ->sortable()
                         ->searchable();
    }

    public static function price(): TextColumn
    {
        return TextColumn::make('price')
                         ->sortable()
                         ->money('USD');
    }
}
