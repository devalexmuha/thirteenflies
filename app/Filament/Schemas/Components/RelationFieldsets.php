<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Fieldset;

class RelationFieldsets
{
    public static function make(string $fieldSetName, string $relationship, array $fields): Fieldset
    {
        return Fieldset::make($fieldSetName)
                       ->relationship($relationship)
                       ->schema($fields);
    }
}
