<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class RelationColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->limitList(2)
             ->badge()
             ->placeholder('—');
    }
}
