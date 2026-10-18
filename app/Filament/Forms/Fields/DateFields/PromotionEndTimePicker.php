<?php

namespace App\Filament\Forms\Fields\DateFields;

class PromotionEndTimePicker extends TimePicker
{

    public static function getDefaultName(): ?string
    {
        return 'sale_ends_at';
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Date end')
             ->required();

    }

}
