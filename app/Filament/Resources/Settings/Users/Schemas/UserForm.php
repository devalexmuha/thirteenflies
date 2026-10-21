<?php

namespace App\Filament\Resources\Settings\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admin')
                       ->schema([
                           Group::make([
                               TextInput::make('first_name')->label('Name')->required(),
                           ])->relationship('userProfile'),


                           TextInput::make('email')
                                    ->label('Email address')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true),

                           Select::make('roles')
                                 ->label('Role')
                                 ->relationship('roles', 'name')
                                 ->multiple()
                                 ->preload()
                                 ->required(),

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
