<?php

namespace App\Filament\Schemas\Panels;

use App\Filament\RelationManagers\FilterAttributesRelationManager;
use App\Filament\Schemas\Fields\StatusFields;
use App\Filament\Schemas\Layouts\ContentLayouts;
use App\Filament\Schemas\Layouts\SeoLayouts;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs\Tab;
use Njxqlus\Filament\Components\Forms\RelationManager;

class FormTabs
{
    public static function contentTab(string $directory, array $blocks): Tab
    {
        return Tab::make('ContentLayouts')->schema(ContentLayouts::make($directory, $blocks));
    }

    public static function attributesTab(): Tab
    {
        return Tab::make('Attributes')
                  ->schema([
                      RelationManager::make()
                                     ->manager(FilterAttributesRelationManager::class)
                                     ->lazy(false),
                  ])
                  ->hiddenOn('create');
    }

    public static function seoTab(array $blocks = ['metaTags']): Tab
    {
        return Tab::make('SEO')->schema(SeoLayouts::make($blocks));
    }

    public static function statusTab(): Tab
    {
        return Tab::make('Status')
                  ->schema(
                      StatusFields::make(['isActive'])
                  );
    }

    public static function productStatusTab(): Tab
    {
        return Tab::make('Status')
                  ->schema([
                      Grid::make()->schema(
                          StatusFields::make(['isActive', 'isFeatured'])
                      )
                  ]);
    }
}
