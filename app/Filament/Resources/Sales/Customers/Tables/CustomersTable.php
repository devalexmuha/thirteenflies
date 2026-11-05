<?php

namespace App\Filament\Resources\Sales\Customers\Tables;

use App\Filament\Tables\Columns\NameColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('userProfile.first_name')
                    ->label('First Name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('userProfile.last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('orders_count')
                    ->label('Orders')
                    ->counts('orders')
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
