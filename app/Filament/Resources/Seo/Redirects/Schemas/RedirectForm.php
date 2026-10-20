<?php

namespace App\Filament\Resources\Seo\Redirects\Schemas;

use App\Enums\RedirectCode;
use App\Filament\Forms\Fields\SelectFields\StatusSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Redirect')
                       ->schema([
                           StatusSelect::make()
                                       ->boolean(trueLabel: 'Active', falseLabel: 'Disabled'),

                           TextInput::make('from_path')
                                    ->label('Redirect from')
                                    ->placeholder('/old-page')
                                    ->required()
                                    ->startsWith('/')
                                    ->unique(ignoreRecord: true),

                           TextInput::make('to_path')
                                    ->label('Redirect to')
                                    ->placeholder('/new-page')
                                    ->required()
                                    ->startsWith('/')
                                    ->different('from_path'),

                           Select::make('status_code')
                                 ->label('Response code')
                                 ->options(RedirectCode::class)
                                 ->default(RedirectCode::MovedPermanently)
                                 ->selectablePlaceholder(false)
                                 ->required(),
                       ])
                       ->inlineLabel()
                       ->columns(1)
                       ->columnSpanFull(),
            ]);
    }
}
