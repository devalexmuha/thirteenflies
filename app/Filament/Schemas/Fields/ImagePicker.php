<?php

namespace App\Filament\Schemas\Fields;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Schemas\Components\Fieldset;

class ImagePicker
{
    public static function make(
        string $fieldLabel = 'Gallery',
        string $fieldName = 'media',
        string $relationshipName = 'media',
        string $relationshipColumn = 'id',
        int $maxItems = 10,
        string $directory = 'Media',
        array $acceptedFileTypes = ['image/jpeg', 'image/png'],
        int $maxSize = 5120
    ): Fieldset {

        return Fieldset::make($fieldLabel)
                       ->schema([
                           CuratorPicker::make($fieldName)
                                        ->relationship($relationshipName, $relationshipColumn)
                                        ->multiple()
                                        ->maxItems($maxItems)
                                        ->directory($directory)
                                        ->columnSpan(2)
                                        ->hiddenLabel()
                                        ->acceptedFileTypes($acceptedFileTypes)
                                        ->maxSize($maxSize),
                       ]);

    }
}
