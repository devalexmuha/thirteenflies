<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\IconColumn;

class ActiveColumn extends IconColumn
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sortable()
             ->boolean()
             ->label('Active');
    }
}
