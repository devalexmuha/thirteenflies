<?php

namespace App\Filament\Components;

use Filament\Forms\Components\RichEditor;

class SeoEditor extends RichEditor
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->toolbarButtons([
            ['source-code'],
            ['bold', 'italic', 'underline', 'strike'],
            ['link'],
            ['h2', 'h3'],
            ['alignStart', 'alignCenter', 'alignEnd'],
            ['bulletList', 'orderedList'],
            ['table'],
            ['undo', 'redo'],
        ])->columnSpan(2);
    }
}
