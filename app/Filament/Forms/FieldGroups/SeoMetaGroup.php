<?php

namespace App\Filament\Forms\FieldGroups;

use Filament\Schemas\Components\Group;

class SeoMetaGroup extends Group
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->relationship('seoMeta');
    }
}
