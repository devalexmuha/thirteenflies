<?php

namespace App\Filament\Resources\Seo\Redirects\Tables;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\NameColumn;
use App\Filament\Tables\Columns\UpdatedAtColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RedirectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                NameColumn::make('from_path'),
                NameColumn::make('to_path'),
                TextColumn::make('status_code')
                    ->numeric()
                    ->sortable(),
                ActiveColumn::make(),
                TextColumn::make('hits')
                    ->numeric()
                    ->sortable(),
                UpdatedAtColumn::make('last_hit_at'),
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
