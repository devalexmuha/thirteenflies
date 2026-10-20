<?php

namespace App\Filament\Resources\Content\Authors\Schemas;

use App\Filament\Actions\SaveAction;
use App\Filament\Forms\Fields\ImageFields\ProfileImagePicker;
use App\Filament\Forms\Layouts\Sections\AuthorSection;
use App\Filament\Forms\Layouts\Sections\PublishSection;
use App\Filament\Forms\Layouts\Sections\SeoSection;
use App\Filament\Forms\Layouts\Sections\SocialsSection;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        Group::make([
                            AuthorSection::make()
                                         ->append([ProfileImagePicker::make()->directory('Authors')]),
                            SocialsSection::make()->collapsed(),
                            SeoSection::make()->collapsed(),
                        ])->columnSpan(['lg' => 2]),

                        PublishSection::make()
                                      ->append([Actions::make([SaveAction::make()])->fullWidth()])
                                      ->columnSpan(['lg' => 1]),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
