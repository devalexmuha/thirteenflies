<?php

namespace App\Filament\Resources\Content\Services\Tables;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\PriceColumn;
use App\Filament\Tables\Columns\RelationColumn;
use App\Filament\Tables\Columns\UpdatedAtColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make(),
                PriceColumn::make('price_from')->label('Price From'),
                RelationColumn::make('author.name'),
                ActiveColumn::make(),
                UpdatedAtColumn::make(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
