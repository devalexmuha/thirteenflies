<?php

namespace App\Filament\Schemas\Fields;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Schemas\Components\Fieldset;

class ImagePicker
{
    public static function fieldSet(
        string $fieldLabel = 'Gallery',
        string $fieldName = 'media',
        string $relationshipName = 'media',
        string $relationshipColumn = 'id',
        int $maxItems = 10,
        string $directory = 'Media',
        array $acceptedFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'],
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

    public static function label(
        string $fieldLabel = 'Gallery',
        string $fieldName = 'media',
        string $relationshipName = 'media',
        string $relationshipColumn = 'id',
        int $maxItems = 10,
        string $directory = 'Media',
        array $acceptedFileTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'],
        int $maxSize = 5120
    ): CuratorPicker {

        return CuratorPicker::make($fieldName)
                            ->relationship($relationshipName, $relationshipColumn)
                            ->label($fieldLabel)
                            ->multiple()
                            ->maxItems($maxItems)
                            ->directory($directory)
                            ->columnSpan(2)
                            ->acceptedFileTypes($acceptedFileTypes)
                            ->maxSize($maxSize);

    }
}
