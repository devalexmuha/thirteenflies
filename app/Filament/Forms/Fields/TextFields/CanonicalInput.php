<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\TextInput;

/**
 * MetaTitleInput::make()
 */
class CanonicalInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'canonical';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Canonical')
             ->columnSpanFull();
    }
}
