<?php

namespace App\Filament\Forms\Layouts\Sections;

use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\Fields\EditorFields\ContentEditor;
use App\Filament\Forms\Fields\EditorFields\SeoEditor;
use App\Filament\Forms\Fields\TextFields\H1Input;
use App\Filament\Forms\Fields\TextFields\NameInput;
use Filament\Forms\Components\TextInput;

class AuthorSection extends FormSection
{

    protected static function defaultHeading(): string
    {
        return 'Author Bio';
    }

    protected function defaultSchema(): array
    {
        return [
            NameInput::make(),
            TextInput::make('position'),
            SeoEditor::make('short_bio')->label('Short Bio'),
            SeoEditor::make('bio')->label('Bio'),
        ];
    }
}
