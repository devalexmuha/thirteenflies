<?php

namespace App\Filament\Forms\Fields\DateFields;

class PromotionStartTimePicker extends TimePicker
{

    public static function getDefaultName(): ?string
    {
        return 'sale_starts_at';
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Date started');

    }

}
