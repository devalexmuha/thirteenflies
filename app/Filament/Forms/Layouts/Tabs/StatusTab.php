<?php

namespace App\Filament\Forms\Layouts\Tabs;

use App\Filament\Forms\Fields\ToggleFields\ActiveToggle;

class StatusTab extends FormTab
{
    protected static function defaultLabel(): string
    {
        return 'Status';
    }

    protected function defaultSchema(): array
    {
        return [ActiveToggle::make()];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->columns(2);
    }
}
