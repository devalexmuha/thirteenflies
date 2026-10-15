<?php

namespace App\Filament\Resources\Catalog\Categories\Schemas;

use App\Filament\RelationManagers\FilterAttributesRelationManager;
use App\Filament\Schemas\SharedFields;
use App\Models\Catalog\Category;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Njxqlus\Filament\Components\Forms\RelationManager;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    SharedFields::contentTab('Categories'),
                    Tab::make('Relationships')
                       ->schema([
                           Select::make('parent_id')
                                 ->relationship('parent', 'name', fn ($query, ?Category $record) => $query
                                     ->when($record, fn ($q) => $q->whereKeyNot($record->id)->whereNotDescendantOf($record))
                                     ->with('ancestors')
                                     ->defaultOrder())
                                 ->getOptionLabelFromRecordUsing(fn (Category $category) => $category->ancestors
                                     ->pluck('name')
                                     ->push($category->name)
                                     ->implode(' > '))
                                 ->placeholder('--- None ---')
                                 ->searchable()
                                 ->preload(),
                       ]),
                    SharedFields::filteringTab(),
                    SharedFields::seoTab([
                        Fieldset::make('Product Meta Template')
                                ->relationship('productMetaTemplate')
                                ->schema([
                                    TextInput::make('meta_title')->columnSpanFull(),
                                    Textarea::make('meta_description')->columnSpanFull(),
                                ]),
                    ]),
                    SharedFields::statusTab(),
                ]),
            ])
            ->columns(1);
    }
}
