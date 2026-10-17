<?php

namespace App\Filament\Tables\Presets;

use App\Filament\Tables\Columns\CommonColumns;
use App\Filament\Tables\Columns\ProductColumns;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ProductColumnSet
{
    public static function make(array $extra = []): array
    {
        return [
            CommonColumns::name(),
            ProductColumns::sku(),
            ProductColumns::price(),
            CommonColumns::isActive(),
            CommonColumns::relationship('categories.name'),
            ...$extra,
        ];
    }
}
