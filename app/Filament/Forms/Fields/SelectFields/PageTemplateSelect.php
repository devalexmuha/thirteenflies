<?php

namespace App\Filament\Forms\Fields\SelectFields;

use App\Enums\PageTemplate;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;

/**
 * RobotsSelect::make()
 */
class PageTemplateSelect extends Select
{
    public static function getDefaultName(): ?string
    {
        return 'template';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Page template')
             ->options(PageTemplate::class)
             ->default(PageTemplate::Single)
             ->selectablePlaceholder(false)
             ->live()
             ->afterStateUpdated(function ($state, Set $set): void {
                 $set('slug.slug', PageTemplate::fromState($state)->slug());
             });
    }
}
