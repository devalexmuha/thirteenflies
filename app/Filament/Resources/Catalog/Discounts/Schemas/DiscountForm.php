<?php

namespace App\Filament\Resources\Catalog\Discounts\Schemas;

use App\Filament\Schemas\Panels\FormTabs;
use App\Filament\Schemas\SharedFields;
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
                        FormTabs::contentTab('Discounts', ['name', 'discountType', 'seoContent', 'mainBanner', 'featuredImage']),
                        FormTabs::seoTab(),
                    ])
            ])
            ->columns(1);
    }
}
