<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class UpdatedAtColumn extends TextColumn
{
    public static function getDefaultName(): ?string
    {
        return 'updated_at';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->dateTime('d.m.Y')
             ->sortable();
    }
}
