<?php

namespace App\Filament\Schemas\Components;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;

class SeoGroup
{
    public static function make(array $fields): Group
    {
        return Group::make()
                    ->relationship('seoMeta')
                    ->schema($fields);
    }
}
