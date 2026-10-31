<?php

namespace App\Filament\Resources\Seo\FilterPages\Tables;

use App\Filament\Tables\Columns\ActiveColumn;
use App\Filament\Tables\Columns\NameColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FilterPagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // H1, Filter Path, Seo Path
                NameColumn::make('seoMeta.h1')->label('H1'),
                TextColumn::make('flt_key')->label('Filter Key'),
                TextColumn::make('slug.slug')->label('Seo Path'),
                ActiveColumn::make(),
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
