<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Tables;

use App\Filament\Tables\Columns\NameColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class FilterAttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make(),
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
