<?php

namespace App\Filament\Forms\Fields\SelectFields;

use Filament\Forms\Components\Select;

/**
 * RobotsSelect::make()
 */
class RobotsSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'robots';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->options([
                'index, follow'     => 'index, follow',
                'noindex, follow'   => 'noindex, follow',
                'noindex, nofollow' => 'noindex, nofollow',
            ])
             ->default('index, follow')
             ->selectablePlaceholder(false);
    }
}
