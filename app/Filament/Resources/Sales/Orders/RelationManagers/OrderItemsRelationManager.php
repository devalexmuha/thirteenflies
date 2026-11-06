<?php

namespace App\Filament\Resources\Sales\Orders\RelationManagers;

use App\Filament\Resources\Catalog\Products\ProductResource;
use App\Filament\Tables\Columns\SkuColumn;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sku')
            ->columns([
                TextColumn::make('product.name')
                          ->label('Product')
                          ->url(fn($record) => $record->product
                              ? ProductResource::getUrl('edit', ['record' => $record->product])
                              : null)
                          ->searchable()
                          ->sortable(),
                SkuColumn::make(),
                TextColumn::make('price')
                          ->money('USD', divideBy: 100)
                          ->sortable(),
                TextColumn::make('quantity')
                          ->sortable(),
                TextColumn::make('total')
                          ->money('USD', divideBy: 100)
                          ->sortable(),
            ]);
    }
}
