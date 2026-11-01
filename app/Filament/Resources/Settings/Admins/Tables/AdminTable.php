<?php

namespace App\Filament\Resources\Settings\Admins\Tables;

use App\Filament\Tables\Columns\NameColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdminTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make('name'),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
