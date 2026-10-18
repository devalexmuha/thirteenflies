<?php

namespace App\Filament\Forms\Blocks;


use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\FieldGroups\SlugGroup;
use App\Filament\Forms\Fields\SelectFields\RobotsSelect;
use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use App\Filament\Forms\Fields\TextFields\SlugInput;
use Filament\Schemas\Components\Group;

class MetaTagsBlock extends Group
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            SeoMetaGroup::make([MetaTitleInput::make()]),
            SlugGroup::make([SlugInput::make()]),
            SeoMetaGroup::make([MetaDescriptionTextarea::make(), RobotsSelect::make()]),
        ]);
    }
}
