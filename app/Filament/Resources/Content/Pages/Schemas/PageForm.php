<?php

namespace App\Filament\Resources\Content\Pages\Schemas;

use App\Enums\PageTemplate;
use App\Filament\Forms\Components\SeoEditor;
use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class PageForm
{
    private const IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/avif'];

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        // LEFT (2/3 width)
                        Group::make([
                            self::contentSection(),
                            self::seoSection(),
                        ])->columnSpan(['lg' => 2]),

                        // RIGHT (1/3 width)
                        self::publishSection()->columnSpan(['lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function contentSection(): Section
    {
        return Section::make('Content')
                      ->schema([
                          TextInput::make('name')
                                   ->required(),

                          Group::make()
                               ->relationship('seoMeta')
                               ->schema([
                                   TextInput::make('h1')->label('H1'),
                               ]),

                          SeoEditor::make('content'),

                          CuratorPicker::make('main_banner')
                                       ->label('Main banner')
                                       ->relationship('mainBanner', 'id')
                                       ->multiple()
                                       ->maxItems(1)
                                       ->directory('pages')
                                       ->acceptedFileTypes(self::IMAGE_TYPES)
                                       ->maxSize(5120),
                      ]);
    }

    private static function seoSection(): Section
    {
        return Section::make('SEO')
                      ->collapsible()
                      ->schema([
                          Group::make()
                               ->relationship('seoMeta')
                               ->schema([
                                   TextInput::make('meta_title'),
                               ]),

                          // Hidden for the Home template: the home page lives at "/" without a slug
                          Group::make()
                               ->relationship('slug')
                               ->visible(function (Get $get): bool {
                                   $template = $get('template');
                                   $value = $template instanceof PageTemplate ? $template->value : $template;

                                   return $value !== PageTemplate::Home->value;
                               })
                               ->schema([
                                   TextInput::make('slug')
                                            ->helperText('Leave empty to generate from name.')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state, '-', ContentLocale::get())))
                                            ->unique(
                                                table: Slug::class,
                                                column: 'slug',
                                                ignoreRecord: true,
                                                modifyRuleUsing: fn (Unique $rule, $livewire) => $rule
                                                    ->where('locale', ContentLocale::get())
                                                    ->where('sluggable_type', $livewire->getModel()),
                                            ),
                               ]),

                          Group::make()
                               ->relationship('seoMeta')
                               ->schema([
                                   Textarea::make('meta_description')->rows(3),
                               ]),
                      ]);
    }

    private static function publishSection(): Section
    {
        return Section::make('Publish')
                      ->schema([
                          Select::make('template')
                                ->label('Page template')
                                ->options(PageTemplate::class)
                                ->default(PageTemplate::Single)
                                ->selectablePlaceholder(false)
                                ->live(),

                          Toggle::make('is_active')
                                ->label('Published')
                                ->default(true),

                          DateTimePicker::make('published_at')
                                        ->label('Publish date')
                                        ->native(false)
                                        ->seconds(false)
                                        ->displayFormat('d.m.Y H:i')
                                        ->default(now()),

                          CuratorPicker::make('featured_image')
                                       ->label('Featured image')
                                       ->relationship('featuredImage', 'id')
                                       ->multiple()
                                       ->maxItems(1)
                                       ->directory('pages')
                                       ->acceptedFileTypes(self::IMAGE_TYPES)
                                       ->maxSize(5120),

                          Actions::make([
                              Action::make('save')
                                    ->label('Save')
                                    ->action(fn ($livewire) => $livewire instanceof CreateRecord
                                        ? $livewire->create()
                                        : $livewire->save()),
                          ])->fullWidth(),
                      ]);
    }
}
