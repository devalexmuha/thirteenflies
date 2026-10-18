<?php

namespace App\Filament\Resources\Catalog\Promotions\RelationManagers;

use App\Filament\Tables\Columns\CommonColumns;
use App\Filament\Tables\Columns\RelationColumn;
use App\Filament\Tables\Filters\ProductFilters;
use App\Filament\Tables\Presets\ProductColumnSet;
use App\Models\Catalog\Product;
use Filament\Actions\Action;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn(): Builder => Product::query()
                                            ->where('products.is_discounted', '=', false)
                                            ->withExists([
                                                'promotions as attached' => fn(Builder $q
                                                ) => $q->whereKey($this->getOwnerRecord()->getKey())
                                            ])
                                            ->orderByDesc('attached'))
            ->recordTitleAttribute('name')
            ->filters(ProductFilters::get(), layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->columns(ProductColumnSet::make(
                [
                    RelationColumn::make('products.name')
                ]
            ))
            ->recordActions([
                Action::make('attach')
                      ->icon('heroicon-m-link')
                      ->color('success')
                      ->hidden(fn(Product $record): bool => $this->isAttached($record))
                      ->action(fn(Product $record) => $this->getOwnerRecord()->products()->attach($record)),
                Action::make('detach')
                      ->icon('heroicon-m-link-slash')
                      ->color('danger')
                      ->visible(fn(Product $record): bool => $this->isAttached($record))
                      ->action(fn(Product $record) => $this->getOwnerRecord()->products()->detach($record)),
            ]);
    }

    protected function resolveTableRecord(?string $key): ?Model
    {
        return Product::find($key);
    }

    protected function isAttached(Product $record): bool
    {
        return $this->getOwnerRecord()->products()->whereKey($record->getKey())->exists();
    }
}
