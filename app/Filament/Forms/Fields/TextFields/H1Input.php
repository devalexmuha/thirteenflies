<?php

namespace App\Filament\Forms\Fields\TextFields;

use Filament\Forms\Components\TextInput;

/**
 * H1Input::make()  — lives on seo_metas, so put it inside SeoMetaGroup.
 */
class H1Input extends TextInput
{
    public static function getDefaultName(): ?string
    {
        return 'h1';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('H1')
             ->columnSpanFull();
    }
}
