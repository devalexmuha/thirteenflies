<?php

namespace App\Filament\Forms\Fields\EditorFields;

class ExcerptEditor extends SeoEditor
{
    public static function getDefaultName(): ?string
    {
        return 'excerpt';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Excerpt');
    }
}
