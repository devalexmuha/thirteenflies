<?php

namespace App\Filament\Resources\Content\Articles\Schemas;

use App\Filament\Actions\SaveAction;
use App\Filament\Forms\Fields\EditorFields\ExcerptEditor;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Layouts\Sections\AuthorsSection;
use App\Filament\Forms\Layouts\Sections\ContentSection;
use App\Filament\Forms\Layouts\Sections\PublishSection;
use App\Filament\Forms\Layouts\Sections\SeoSection;
use App\Filament\Forms\Layouts\Sections\SocialsSection;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Group::make([
                            ContentSection::make()
                                          ->append([
                                              ExcerptEditor::make(),
                                              MainBannerPicker::make()->directory('Articles')]),
                            AuthorsSection::make()->collapsed(false),
                            SeoSection::make()->collapsed(),
                        ])->columnSpan(['lg' => 2]),

                        PublishSection::make()
                                      ->append([
                                          FeaturedImagePicker::make()->directory('Articles'),
                                          Actions::make([SaveAction::make()])->fullWidth()
                                      ])
                                      ->columnSpan(['lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
