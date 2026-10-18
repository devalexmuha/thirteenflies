<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\Fields\EditorFields\ContentEditor;
use App\Filament\Forms\Fields\TextFields\H1Input;

class ContentSection extends FormSection
{

    protected static function defaultHeading(): string
    {
        return 'Content';
    }

    protected function defaultSchema(): array
    {
        return [
            SeoMetaGroup::make()->schema([H1Input::make()]),
            ContentEditor::make(),
        ];
    }
}
