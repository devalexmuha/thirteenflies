<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class CountColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $relationship = Str::beforeLast($this->getName(), '_count');

        $this->counts($relationship)
             ->label(Str::headline($relationship))
             ->sortable();
    }
}
