<?php

namespace App\Filament\Forms\Fields\DateFields;

class PublishedAtTimePicker extends TimePicker
{

    public static function getDefaultName(): ?string
    {
        return 'published_at';
    }


    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Published At');

    }

}
