<?php

namespace App\Filament\Forms\Fields\ImageFields;

use Awcodes\Curator\Components\Forms\CuratorPicker;

abstract class ImagePicker extends CuratorPicker
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->multiple()
             ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'])
             ->maxSize(5120)
             ->columnSpanFull();
    }
}
