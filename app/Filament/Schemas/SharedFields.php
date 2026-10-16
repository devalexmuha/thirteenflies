<?php

namespace App\Filament\Schemas;

use App\Filament\Components\SeoEditor;
use App\Filament\RelationManagers\FilterAttributesRelationManager;
use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use Njxqlus\Filament\Components\Forms\RelationManager;

class SharedFields
{
    public static function contentTab(string $bannerDirectory, array $extra = [], bool $nameIsDisabled = false): Tab
    {
        return Tab::make('Content')
                  ->schema([
                      TextInput::make('name')->required()->disabled($nameIsDisabled),
                      self::seoContent(),
                      self::mainBanner($bannerDirectory),
                      ...$extra,
                  ]);
    }

    public static function seoContent(): Group
    {
        return Group::make()
                    ->relationship('seoMeta')
                    ->schema([
                        TextInput::make('h1')->columnSpan(2),
                        SeoEditor::make('seo_text_top')->label('Top Description'),
                        SeoEditor::make('seo_text_bottom')->label('Bottom Description'),
                    ]);
    }

    public static function mainBanner(string $directory): Fieldset
    {
        return Fieldset::make('Main Banner')
                       ->schema([
                           CuratorPicker::make('media')
                                        ->relationship('media', 'id')
                                        ->multiple()
                                        ->maxItems(1)
                                        ->directory($directory)
                                        ->columnSpan(2)
                                        ->hiddenLabel()
                                        ->acceptedFileTypes([
                                            'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'
                                        ])
                                        ->maxSize(5120),
                       ]);
    }

    public static function photos(string $directory): Fieldset
    {
        return Fieldset::make('Photos')
                       ->schema([
                           CuratorPicker::make('media')
                                        ->relationship('media', 'id')
                                        ->multiple()
                                        ->maxItems(10)
                                        ->directory($directory)
                                        ->columnSpan(2)
                                        ->hiddenLabel()
                                        ->acceptedFileTypes([
                                            'image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'
                                        ])
                                        ->maxSize(5120),
                       ]);
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

    public static function seoTab(array $extra = []): Tab
    {
        return Tab::make('SEO')
                  ->schema([
                      Group::make()
                           ->relationship('seoMeta')
                           ->schema([
                               TextInput::make('meta_title'),
                           ]),
                      Group::make()
                           ->relationship('slug')
                           ->schema([
                               TextInput::make('slug')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn($state, $set) => $set('slug',
                                            Str::slug($state, '-', ContentLocale::get())))
                                        ->unique(
                                            table: Slug::class,
                                            column: 'slug',
                                            ignoreRecord: true,
                                            modifyRuleUsing: fn(Unique $rule, $livewire) => $rule
                                                ->where('locale', ContentLocale::get())
                                                ->where('sluggable_type', $livewire->getModel()),
                                        )->required(),
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
                                     ->selectablePlaceholder(false),
                           ]),
                      ...$extra,
                  ]);
    }

    public static function statusTab(array $extra = []): Tab
    {
        return Tab::make('Status')
                  ->schema([
                      Grid::make(2)->schema([
                          Toggle::make('is_active')->default(true),
                          ...$extra,
                      ])
                  ]);
    }
}
