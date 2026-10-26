<?php

namespace App\Filament\Resources\Content\Pages\Schemas;

use App\Enums\PageTemplate;
use App\Filament\Actions\SaveAction;
use App\Filament\Forms\FieldGroups\SeoMetaGroup;
use App\Filament\Forms\FieldGroups\SlugGroup;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Fields\SelectFields\PageTemplateSelect;
use App\Filament\Forms\Fields\SelectFields\RobotsSelect;
use App\Filament\Forms\Fields\TextFields\CanonicalInput;
use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use App\Filament\Forms\Fields\TextFields\SlugInput;
use App\Filament\Forms\Layouts\Sections\ContentSection;
use App\Filament\Forms\Layouts\Sections\PublishSection;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Group::make([
                            ContentSection::make()
                                          ->append([MainBannerPicker::make()->directory('pages')]),
                            self::seoSection(),
                        ])->columnSpan(['lg' => 2]),

                        PublishSection::make()
                                      ->prepend([PageTemplateSelect::make()])
                                      ->append([FeaturedImagePicker::make()->directory('pages'),
                                          Actions::make([SaveAction::make()])->fullWidth(),])
                                      ->columnSpan(['lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    private static function seoSection(): Section
    {
        return Section::make('SEO')
                      ->collapsed()
                      ->schema([
                          SeoMetaGroup::make([MetaTitleInput::make()]),
                          SlugGroup::make([
                              SlugInput::make()
                                       ->disabled(fn(Get $get
                                       ): bool => PageTemplate::fromState($get('../template'))->slug() !== null)
                                       ->dehydrated(),
                          ]),
                          SeoMetaGroup::make([MetaDescriptionTextarea::make(), RobotsSelect::make(), CanonicalInput::make()])
                      ]);
    }
}
