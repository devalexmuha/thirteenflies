<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                          ->sortable()
                          ->searchable(),
                TextColumn::make('sku'),
                TextColumn::make('price')
                          ->sortable()
                          ->money('USD'),
                IconColumn::make('is_active')
                          ->boolean()
                          ->sortable()
                          ->toggleable(),
                TextColumn::make('categories.name')
                          ->badge(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                          ->color('primary'),
                DeleteAction::make()
                            ->color('danger'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
