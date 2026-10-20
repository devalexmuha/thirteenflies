<?php

namespace App\Filament\Resources\Seo\SeoTemplates\Schemas;

use App\Filament\Forms\Fields\TextFields\MetaDescriptionTextarea;
use App\Filament\Forms\Fields\TextFields\MetaTitleInput;
use App\Models\Seo\SeoTemplate;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SeoTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Seo Meta Templates')
                       ->description(fn(?SeoTemplate $record): string => 'Available variables: '
                                                                         .implode(', ',
                               $record?->page_type->variables() ?? []))
                       ->schema([
                           MetaTitleInput::make(),
                           MetaDescriptionTextarea::make(),
                       ])
                       ->columnSpanFull(),
            ]);
    }
}
