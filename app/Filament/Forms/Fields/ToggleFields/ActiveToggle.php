<?php

namespace App\Filament\Forms\Fields\ToggleFields;

use Filament\Forms\Components\Toggle;

/**
 * ActiveToggle::make()
 */
class ActiveToggle extends Toggle
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Active')
             ->default(true);
    }
}
