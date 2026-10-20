<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\TextInput;

class PriceInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'price';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->numeric()
             ->prefix('$')
             ->required();
    }
}
