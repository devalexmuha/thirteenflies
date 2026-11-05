<?php

namespace App\Filament\Resources\Settings\Admins\Schemas;

use App\Filament\Forms\Fields\TextFields\NameInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admin')
                    ->schema([
                        NameInput::make(),

                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        Select::make('roles')
                              ->preload()
                              ->multiple()
                              ->relationship('roles', 'name'),

                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
