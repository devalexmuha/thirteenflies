<?php

namespace App\Filament\Forms\Blocks;


use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\Fields\EditorFields\BottomDescriptionEditor;
use App\Filament\Forms\Fields\EditorFields\TopDescriptionEditor;
use App\Filament\Forms\Fields\TextFields\H1Input;

/**
 * H1 + top/bottom SEO texts (for catalog pages: categories, brands, promotions...).
 * SeoContentBlock::make()
 */
class SeoContentBlock extends SeoMetaGroup
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            H1Input::make(),
            TopDescriptionEditor::make(),
            BottomDescriptionEditor::make(),
        ]);
    }
}
