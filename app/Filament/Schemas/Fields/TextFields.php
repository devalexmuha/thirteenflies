<?php

namespace App\Filament\Schemas\Fields;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;

class TextFields
{
    public static function h1(): Group
    {
        return Group::make()
                    ->relationship('seoMeta')
                    ->schema([
                        TextInput::make('h1')->columnSpan(2),
                    ]);
    }


}
