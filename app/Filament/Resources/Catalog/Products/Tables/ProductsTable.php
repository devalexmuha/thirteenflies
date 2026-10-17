<?php

namespace App\Filament\Resources\Catalog\Products\Tables;

use App\Filament\Tables\Filters\ProductFilters;
use App\Filament\Tables\Presets\ProductColumnSet;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(ProductColumnSet::make())
            ->filters(ProductFilters::get([
                TernaryFilter::make('is_discounted')->label('Discounted'),
            ]), layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(5)
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
