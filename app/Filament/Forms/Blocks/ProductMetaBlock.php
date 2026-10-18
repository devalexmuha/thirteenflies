<?php

namespace App\Filament\Forms\Blocks;


use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use Filament\Schemas\Components\Fieldset;

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
                 MetaTitleInput::make(),
                 MetaDescriptionTextarea::make(),
             ]);
    }
}
