<?php

namespace App\Filament\Resources\Catalog\Promotions\Schemas;

use App\Filament\Forms\Blocks\SeoContentBlock;
use App\Filament\Forms\FieldGroups\ImageFieldset;
use App\Filament\Forms\Fields\DateFields\PromotionEndTimePicker;
use App\Filament\Forms\Fields\DateFields\PromotionStartTimePicker;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Fields\TextFields\NameInput;
use App\Filament\Forms\Fields\ToggleFields\ActiveToggle;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use App\Filament\Resources\Catalog\Promotions\RelationManagers\ProductsRelationManager;
use App\Filament\Schemas\SharedFields;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Njxqlus\Filament\Components\Forms\RelationManager;

class PromotionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    Tab::make('Content')->schema([
                        NameInput::make(),
                        SeoContentBlock::make(),
                        ImageFieldset::wrap(MainBannerPicker::make()->directory('Promotions')),
                        ImageFieldset::wrap(FeaturedImagePicker::make()->directory('Promotions')),
                    ]),
                    Tab::make('Settings')
                       ->schema([
                           Grid::make(2)
                               ->schema([
                                   PromotionStartTimePicker::make(),
                                   PromotionEndTimePicker::make()
                                                         ->after('sale_starts_at'),
                                   TextInput::make('discount_rate')
                                            ->label('Discount rate')
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->suffix('%'),
                                   ActiveToggle::make()
                                               ->inline(false),
                               ]),
                           RelationManager::make()
                                          ->manager(ProductsRelationManager::class)
                                          ->lazy(false)
                                          ->hiddenOn('create'),
                       ]),
                    SeoTab::make(),
                ]),
            ])
            ->columns(1);
    }
}
