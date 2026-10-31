<?php

namespace App\Filament\Resources\Content\Pages\Tables;

use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\UpdatedAtColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make(),
                UpdatedAtColumn::make(),
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
