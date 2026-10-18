<?php

namespace App\Filament\Forms\Fields\ImageFields;

class GalleryPicker extends ImagePicker
{
    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Gallery')
             ->relationship('media', 'id')
             ->maxItems(10);
    }
}
