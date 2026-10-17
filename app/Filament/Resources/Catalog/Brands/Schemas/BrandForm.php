<?php

namespace App\Filament\Resources\Catalog\Brands\Schemas;

use App\Filament\Schemas\SharedFields;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class BrandForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    SharedFields::contentTab('Brands'),
                    SharedFields::attributesTab(),
                    SharedFields::seoTab(),
                    SharedFields::statusTab(),
                ]),
            ])
            ->columns(1);
    }
}
