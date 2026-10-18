<?php

namespace App\Filament\Resources\Catalog\Brands\Schemas;

use App\Filament\Forms\Blocks\ProductMetaBlock;
use App\Filament\Forms\Blocks\SeoContentBlock;
use App\Filament\Forms\FieldGroups\ImageFieldset;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Fields\TextFields\NameInput;
use App\Filament\Forms\Layouts\Tabs\AttributesTab;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use App\Filament\Forms\Layouts\Tabs\StatusTab;
use App\Filament\Schemas\Panels\FormTabs;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    Tab::make('Content')->schema([
                        NameInput::make(),
                        SeoContentBlock::make(),
                        ImageFieldset::wrap(MainBannerPicker::make()->directory('Brands')),
                        ImageFieldset::wrap(FeaturedImagePicker::make()->directory('Brands')),
                    ]),
                    AttributesTab::make(),
                    SeoTab::make(),
                    StatusTab::make(),
                ]),
            ])
            ->columns(1);
    }
}
