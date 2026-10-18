<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\TextInput;

/**
 * NameInput::make()
 */
class NameInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'name';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->required();
    }
}
