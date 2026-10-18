<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class PriceColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'price';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable()
             ->money('USD');
    }
}
