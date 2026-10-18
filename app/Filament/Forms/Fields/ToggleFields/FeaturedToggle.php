<?php

namespace App\Filament\Forms\Fields\ToggleFields;

use Filament\Forms\Components\Toggle;

/**
 * FeaturedToggle::make()
 */
class FeaturedToggle extends Toggle
{
    public static function getDefaultName(): ?string
    {
        return 'is_featured';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Featured')
             ->default(false);
    }
}
