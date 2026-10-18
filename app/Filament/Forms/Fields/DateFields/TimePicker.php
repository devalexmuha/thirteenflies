<?php

namespace App\Filament\Forms\Fields\DateFields;

use Filament\Forms\Components\DateTimePicker;

/**
 * TimePicker::make()
 */
abstract class TimePicker extends DateTimePicker
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->native(false)
             ->seconds(false)
             ->displayFormat('d.m.Y H:i')
             ->default(fn() => now());
    }
}
