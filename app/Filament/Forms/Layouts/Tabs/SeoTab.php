<?php

namespace App\Filament\Forms\Layouts\Tabs;

use App\Filament\Forms\Blocks\MetaTagsBlock;

class SeoTab extends FormTab
{
    protected static function defaultLabel(): string
    {
        return 'SEO';
    }

    protected function defaultSchema(): array
    {
        return [MetaTagsBlock::make()];
    }
}
