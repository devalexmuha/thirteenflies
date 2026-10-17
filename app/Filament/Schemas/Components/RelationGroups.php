<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Group;

class RelationGroups
{
    public static function make(string $relationship, array $fields): Group
    {
        return Group::make()
                    ->relationship($relationship)
                    ->schema($fields);
    }
}
