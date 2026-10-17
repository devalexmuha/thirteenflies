<?php

namespace App\Filament\Tables\Presets;

use App\Filament\Tables\Columns\CommonColumns;

class CatalogColumnSet
{
    public static function get(array $extra = []): array
    {
        return [
            CommonColumns::name(),
            CommonColumns::isActive(),
            CommonColumns::count('products'),
            ...$extra,
        ];
    }
}
