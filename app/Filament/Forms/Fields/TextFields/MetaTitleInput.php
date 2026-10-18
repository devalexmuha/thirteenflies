<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\TextInput;

/**
 * MetaTitleInput::make()
 */
class MetaTitleInput extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'meta_title';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Meta title')
             ->columnSpanFull();
    }
}
