<?php

namespace App\Filament\Forms\Fields\ImageFields;

class FeaturedImagePicker extends ImagePicker
{
    public static function getDefaultName(): ?string
    {
        return 'featured_image';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Featured Image')
             ->relationship('featuredImage', 'id')
             ->maxItems(1)
             ->extraAttributes(['class' => 'single-image-picker']);
    }
}
