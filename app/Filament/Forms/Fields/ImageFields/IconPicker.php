<?php

namespace App\Filament\Forms\Fields\ImageFields;

class IconPicker extends ImagePicker
{
    public static function getDefaultName(): ?string
    {
        return 'image';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Icon')
             ->maxItems(1)
             ->directory('Icons');
    }
}
