<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\Textarea;

/**
 * MetaDescriptionTextarea::make()
 */
class MetaDescriptionTextarea extends Textarea
{
    public static function getDefaultName(): ?string
    {
        return 'meta_description';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Meta description')
             ->columnSpanFull();
    }
}
