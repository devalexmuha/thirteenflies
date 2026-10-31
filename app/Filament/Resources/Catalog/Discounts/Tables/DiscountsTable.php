<?php

namespace App\Filament\Resources\Catalog\Discounts\Tables;

use App\Filament\Tables\Columns\CountColumn;
use App\Filament\Tables\Columns\NameColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class DiscountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make(),
                CountColumn::make('products_count'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
