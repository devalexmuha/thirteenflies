<?php

namespace App\Filament\Forms\Blocks;

use App\Enums\SeoTemplateType;
use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Text;

/**
 * Meta title/description template for the products of a category.
 * ProductMetaBlock::make()
 */
class ProductMetaBlock extends Fieldset
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Product Meta Template')
            ->relationship('productMetaTemplates')
            ->schema([
                Text::make('Available variables: '.implode(', ', SeoTemplateType::Product->variables()))
                    ->columnSpanFull(),
                MetaTitleInput::make()->hiddenLabel()->placeholder('Title'),
                MetaDescriptionTextarea::make()->hiddenLabel()->placeholder('Description'),
            ]);
    }
}
