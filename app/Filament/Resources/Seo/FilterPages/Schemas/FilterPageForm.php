<?php

namespace App\Filament\Resources\Seo\FilterPages\Schemas;

use App\Filament\Forms\Blocks\SeoContentBlock;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use App\Filament\Forms\Layouts\Tabs\StatusTab;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FilterPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    Tab::make('Content')->schema([
                        SeoContentBlock::make(),
                    ]),
                    Tab::make('Settings')
                       ->schema([
                           // select btw brand and category
                           Select::make('filterable_type')
                                 ->label('Page for')
                                 ->options([
                                     Category::class => 'Category',
                                     Brand::class    => 'Brand',
                                 ])
                                 ->required()
                                 ->live()
                                 ->afterStateUpdated(function (Get $get, Set $set): void {
                                     $set('filterable_id', null);
                                     $set('filters', []);
                                 }),

                           //select brand or category
                           Select::make('filterable_id')
                                 ->label(fn(Get $get
                                 ): string => $get('filterable_type') === Brand::class ? 'Brand' : 'Category')
                                 ->options(fn(Get $get): array => $get('filterable_type')::query()->get()
                                                                                         ->mapWithKeys(fn($record
                                                                                         ) => [$record->id => $record->name])
                                                                                         ->all())
                                 ->searchable()
                                 ->required()
                                 ->live()
                                 ->visible(fn(Get $get): bool => filled($get('filterable_type'))),

                           TextInput::make('flt_key')
                                    ->label('Filter Key')
                                    ->prefix('/flt/')
                                    ->suffix('/')
                                    ->required()
                                    ->rules(['not_regex:/\//'])
                                    ->validationMessages(['not_regex' => 'Use filter key without "/"'])
                                    ->formatStateUsing(fn(?string $state): ?string => $state
                                        ? trim(Str::after($state, '/flt/'), '/')
                                        : null)
                                    ->dehydrateStateUsing(fn(?string $state): ?string => $state
                                        ? '/flt/'.trim($state, '/').'/'
                                        : null)
                                    ->visible(fn(Get $get): bool => filled($get('filterable_id'))),
                       ]),
                    SeoTab::make(),
                    StatusTab::make(),
                ])
            ])->columns(1);
    }
}
