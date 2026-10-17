<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Tables;

use App\Filament\Tables\Columns\CommonColumns;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilterAttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                CommonColumns::name(),
            ])
            ->filters([
                //
            ])
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
