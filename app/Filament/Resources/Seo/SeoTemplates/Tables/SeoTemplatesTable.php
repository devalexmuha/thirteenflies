<?php

namespace App\Filament\Resources\Seo\SeoTemplates\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeoTemplatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('page_type')
                    ->label('Page type')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
