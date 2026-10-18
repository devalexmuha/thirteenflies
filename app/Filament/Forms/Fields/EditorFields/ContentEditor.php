<?php

namespace App\Filament\Forms\Fields\EditorFields;

class ContentEditor extends SeoEditor
{
    public static function getDefaultName(): ?string
    {
        return 'content';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Content');
    }
}
