<?php

namespace App\Filament\Resources\Catalog\Categories\Tables;

use App\Filament\Tables\Columns\RelationColumn;
use App\Filament\Tables\Presets\CatalogColumnSet;
use App\Models\Catalog\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(CatalogColumnSet::get([
                RelationColumn::make('ancestors')
                          ->label('Parents')
                          ->state(fn(Category $record) => $record->ancestors->sortBy('_lft')->pluck('name')->all())
            ]))
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
