<?php

namespace App\Filament\Resources\Catalog\Brands\Schemas;

use App\Filament\Schemas\Panels\FormTabs;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    FormTabs::contentTab('Brands', ['name', 'seoContent', 'mainBanner', 'featuredImage']),
                    FormTabs::attributesTab(),
                    FormTabs::seoTab(),
                    FormTabs::statusTab(),
                ]),
            ])
            ->columns(1);
    }
}
