<?php

namespace App\Filament\Resources\Catalog\Discounts\Schemas;

use App\Filament\Forms\Blocks\SeoContentBlock;
use App\Filament\Forms\FieldGroups\ImageFieldset;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Fields\TextFields\NameInput;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class DiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->tabs([
                        Tab::make('Content')->schema([
                            NameInput::make(),
                            TextInput::make('type')->disabled(),
                            SeoContentBlock::make(),
                            ImageFieldset::wrap(MainBannerPicker::make()->directory('Discounts')),
                            ImageFieldset::wrap(FeaturedImagePicker::make()->directory('Discounts')),
                        ]),
                        SeoTab::make(),
                    ])
            ])
            ->columns(1);
    }
}
