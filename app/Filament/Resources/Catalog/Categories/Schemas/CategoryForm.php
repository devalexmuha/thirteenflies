<?php

namespace App\Filament\Resources\Catalog\Categories\Schemas;

use App\Filament\RelationManagers\FilterAttributesRelationManager;
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
                    Tab::make('Content')
                       ->schema([
                           TextInput::make('name')
                                    ->required(),
                           Group::make()
                                ->relationship('seoMeta')
                                ->schema([
                                    TextInput::make('h1')
                                             ->columnSpan(2),
                                    RichEditor::make('seo_text_top')
                                              ->label('Top Description')
                                              ->toolbarButtons([
                                                  ['source-code'],
                                                  ['bold', 'italic', 'underline', 'strike'],
                                                  ['link'],
                                                  ['h2', 'h3'],
                                                  ['alignStart', 'alignCenter', 'alignEnd'],
                                                  ['bulletList', 'orderedList'],
                                                  ['table'],
                                                  ['undo', 'redo'],
                                              ])
                                              ->columnSpan(2),
                                    RichEditor::make('seo_text_bottom')
                                              ->label('Bottom Description')
                                              ->toolbarButtons([
                                                  ['source-code'],
                                                  ['bold', 'italic', 'underline', 'strike'],
                                                  ['link'],
                                                  ['h2', 'h3'],
                                                  ['alignStart', 'alignCenter', 'alignEnd'],
                                                  ['bulletList', 'orderedList'],
                                                  ['table'],
                                                  ['undo', 'redo'],
                                              ])
                                              ->columnSpan(2),
                                ]),
                           Fieldset::make('Main Banner')
                                   ->schema([
                                       CuratorPicker::make('media')
                                                    ->relationship('media', 'id')
                                                    ->multiple()
                                                    ->maxItems(1)
                                                    ->directory('categories')
                                                    ->columnSpan(2)
                                                    ->hiddenLabel()
                                                    ->acceptedFileTypes([
                                                        'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml',
                                                        'image/avif',
                                                    ])
                                                    ->maxSize(5120),
                                   ]),
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
                    Tab::make('Filtering')
                       ->schema([
                           RelationManager::make()
                                          ->manager(FilterAttributesRelationManager::class)
                                          ->lazy(false),
                       ])->hiddenOn('create'),
                    Tab::make('SEO')
                       ->schema([
                           Group::make()
                                ->relationship('seoMeta')
                                ->schema([
                                    TextInput::make('meta_title')
                                             ->required()
                                ]),
                           Group::make()
                                ->relationship('slug')
                                ->schema([
                                    TextInput::make('slug')
                                             ->required(),
                                ]),
                           Group::make()
                                ->relationship('seoMeta')
                                ->schema([
                                    Textarea::make('meta_description'),
                                    Select::make('robots')
                                          ->options([
                                              'index, follow'     => 'index, follow',
                                              'noindex, follow'   => 'noindex, follow',
                                              'noindex, nofollow' => 'noindex, nofollow',
                                          ])
                                          ->default('index, follow')
                                          ->required(),
                                ]),
                           Fieldset::make('Product Meta Template')
                                   ->relationship('productMetaTemplate')
                                   ->schema([
                                       TextInput::make('meta_title')
                                                ->columnSpanFull(),
                                       Textarea::make('meta_description')
                                               ->columnSpanFull(),
                                   ]),
                       ]),
                    Tab::make('Status')
                       ->schema([
                           Toggle::make('is_active')
                                 ->default(true),
                       ]),
                ]),
            ])->columns(1);

    }
}
