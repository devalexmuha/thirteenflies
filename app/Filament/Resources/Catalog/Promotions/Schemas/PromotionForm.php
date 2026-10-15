<?php

namespace App\Filament\Resources\Catalog\Promotions\Schemas;

use App\Filament\Resources\Catalog\Promotions\RelationManagers\ProductsRelationManager;
use App\Filament\Schemas\SharedFields;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                    SharedFields::contentTab('Promotions'),
                    Tab::make('Settings')
                       ->schema([
                           Grid::make(2)
                               ->schema([
                                   DateTimePicker::make('sale_starts_at')
                                                 ->label('Date started')
                                                 ->required()
                                                 ->native(false),
                                   DateTimePicker::make('sale_ends_at')
                                                 ->label('Date end')
                                                 ->required()
                                                 ->native(false)
                                                 ->after('sale_starts_at'),
                                   TextInput::make('discount_rate')
                                            ->label('Discount rate')
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(100)
                                            ->suffix('%'),
                                   Toggle::make('is_active')
                                         ->inline(false)
                                         ->default(true),
                               ]),
                           RelationManager::make()
                                          ->manager(ProductsRelationManager::class)
                                          ->lazy(false)
                                          ->hiddenOn('create'),
                       ]),
                    SharedFields::seoTab(),
                ]),
            ])
            ->columns(1);
    }
}
