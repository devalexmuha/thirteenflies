<?php

namespace App\Filament\Forms\Fields\EditorFields;

use Filament\Forms\Components\RichEditor;

class SeoEditor extends RichEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->toolbarButtons([
            ['source-code'],
            ['bold', 'italic', 'underline', 'strike'],
            ['link', 'attachFiles'],
            ['h2', 'h3'],
            ['alignStart', 'alignCenter', 'alignEnd'],
            ['bulletList', 'orderedList'],
            ['table'],
            ['undo', 'redo'],
        ])
             ->fileAttachmentsDisk('public')
             ->fileAttachmentsDirectory('editor-content')
             ->fileAttachmentsVisibility('public')
             ->columnSpan(2);
    }
}
