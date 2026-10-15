<?php

namespace App\Filament\Resources\Catalog\Categories\Tables;

use App\Filament\Tables\Columns\CatalogColumns;
use App\Models\Catalog\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(CatalogColumns::get([
                TextColumn::make('ancestors')
                          ->label('Parents')
                          ->state(fn(Category $record) => $record->ancestors->sortBy('_lft')->pluck('name')->all())
                          ->badge()
                          ->placeholder('—')
            ]))
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
