<?php

namespace App\Filament\Resources\Settings\Admins\Tables;

use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\RelationColumn;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make('userProfile.first_name')->label('Name'),
                TextColumn::make('email')
                          ->label('Email address')
                          ->searchable(),
                RelationColumn::make('roles.name')->label('Role'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }
}
