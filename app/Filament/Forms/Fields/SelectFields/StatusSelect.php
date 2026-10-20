<?php

namespace App\Filament\Forms\Fields\SelectFields;

use Filament\Forms\Components\Select;

/**
 * RobotsSelect::make()
 */
class StatusSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'is_active';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Status')
               ->default(true)
               ->selectablePlaceholder(false);
    }
}
