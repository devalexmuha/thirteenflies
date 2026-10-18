<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class SkuColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'sku';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable()
             ->searchable();
    }
}
