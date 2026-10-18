<?php

namespace App\Filament\Forms\Fields\EditorFields;

class BottomDescriptionEditor extends SeoEditor
{
    public static function getDefaultName(): ?string
    {
        return 'seo_text_bottom';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Bottom Description');
    }
}
