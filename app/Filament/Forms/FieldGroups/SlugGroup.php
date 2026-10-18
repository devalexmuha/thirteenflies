<?php

namespace App\Filament\Forms\FieldGroups;

use Filament\Schemas\Components\Group;

class SlugGroup extends Group
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->relationship('slug');
    }
}
