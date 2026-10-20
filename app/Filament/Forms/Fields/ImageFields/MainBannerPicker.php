<?php

namespace App\Filament\Forms\Fields\ImageFields;

class MainBannerPicker extends ImagePicker
{
    public static function getDefaultName(): ?string
    {
        return 'main_banner';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Main Banner')
             ->relationship('mainBanner', 'id')
             ->maxItems(1)
             ->extraAttributes(['class' => 'single-image-picker']);
    }
}
