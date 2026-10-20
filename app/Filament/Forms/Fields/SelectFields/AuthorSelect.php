<?php

namespace App\Filament\Forms\Fields\SelectFields;

use Filament\Forms\Components\Select;

class AuthorSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'author_id';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Author')
             ->relationship('author', 'name')
             ->searchable()
             ->preload();
    }
}
