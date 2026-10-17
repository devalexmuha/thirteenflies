<?php

namespace App\Filament\Resources\Catalog\Categories\Schemas;

use App\Filament\Schemas\Panels\FormTabs;
use App\Models\Catalog\Category;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    FormTabs::contentTab('Categories', ['name', 'seoContent', 'mainBanner', 'featuredImage']),
                    Tab::make('Relationships')
                       ->schema([
                           Select::make('parent_id')
                                 ->relationship('parent', 'name', fn($query, ?Category $record) => $query
                                     ->when($record,
                                         fn($q) => $q->whereKeyNot($record->id)->whereNotDescendantOf($record))
                                     ->with('ancestors')
                                     ->defaultOrder())
                                 ->getOptionLabelFromRecordUsing(fn(Category $category) => $category->ancestors
                                     ->pluck('name')
                                     ->push($category->name)
                                     ->implode(' > '))
                                 ->placeholder('--- None ---')
                                 ->searchable()
                                 ->preload(),
                       ]),
                    FormTabs::attributesTab(),
                    FormTabs::seoTab(['metaTags', 'productMetaTemplates']),
                    FormTabs::statusTab(),
                ]),
            ])
            ->columns(1);
    }
}
