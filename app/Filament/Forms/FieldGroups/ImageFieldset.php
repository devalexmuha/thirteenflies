<?php

namespace App\Filament\Forms\FieldGroups;

use App\Filament\Forms\Fields\ImageFields\ImagePicker;
use Filament\Schemas\Components\Fieldset;

class ImageFieldset extends Fieldset
{
    public static function wrap(ImagePicker $picker): static
    {
        return static::make($picker->getLabel())
                     ->schema([$picker->hiddenLabel()]);
    }
}
