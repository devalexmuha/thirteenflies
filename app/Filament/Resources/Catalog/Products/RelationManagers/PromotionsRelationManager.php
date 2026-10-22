<?php

namespace App\Filament\Resources\Catalog\Products\RelationManagers;

use App\Filament\Resources\Catalog\Promotions\PromotionResource;
use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\RelationNameColumn;
use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
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
                RelationNameColumn::make()
                    ->linkToResource(PromotionResource::class),
                TextColumn::make('discount_rate')
                    ->suffix('%')
                    ->sortable(),
                ActiveColumn::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}
