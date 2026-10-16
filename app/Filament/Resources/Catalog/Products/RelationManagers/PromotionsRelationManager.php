<?php

namespace App\Filament\Resources\Catalog\Products\RelationManagers;

use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PromotionsRelationManager extends RelationManager
{
    protected static string $relationship = 'promotions';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('discount_rate')
                          ->suffix('%')
                          ->sortable(),
                IconColumn::make('is_active')
                          ->boolean()
                          ->sortable(),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}

