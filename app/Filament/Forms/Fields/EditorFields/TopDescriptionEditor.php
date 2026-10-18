<?php

namespace App\Filament\Forms\Fields\EditorFields;

class TopDescriptionEditor extends SeoEditor
{
    public static function getDefaultName(): ?string
    {
        return 'seo_text_top';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Top Description');
    }
}
