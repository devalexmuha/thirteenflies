<?php

namespace App\Filament\Resources\Catalog\Categories\Tables;

use App\Models\Catalog\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                          ->sortable()
                          ->searchable(),
                IconColumn::make('is_active')
                          ->boolean()
                          ->sortable(),
                TextColumn::make('ancestors')
                          ->label('Parents')
                          ->state(fn (Category $record) => $record->ancestors->sortBy('_lft')->pluck('name')->all())
                          ->badge()
                          ->placeholder('—'),
                TextColumn::make('products_count')
                          ->label('Products')
                          ->counts('products')
                          ->sortable(),
            ])
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
