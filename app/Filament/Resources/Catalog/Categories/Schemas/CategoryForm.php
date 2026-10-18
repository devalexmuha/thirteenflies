<?php

namespace App\Filament\Resources\Catalog\Categories\Schemas;

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
                    Tab::make('Content')->schema([
                        NameInput::make(),
                        SeoContentBlock::make(),
                        ImageFieldset::wrap(MainBannerPicker::make()->directory('categories')),
                        ImageFieldset::wrap(FeaturedImagePicker::make()->directory('categories')),
                    ]),
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
                    AttributesTab::make(),
                    SeoTab::make()->append([ProductMetaBlock::make()]),
                    StatusTab::make(),
                ]),
            ])
            ->columns(1);
    }
}
