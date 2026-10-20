<?php

namespace App\Filament\Forms\Fields\ImageFields;

class ProfileImagePicker extends ImagePicker
{
    public static function getDefaultName(): ?string
    {
        return 'media';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Profile picture')
             ->relationship('media', 'id')
             ->maxItems(1);
    }
}
