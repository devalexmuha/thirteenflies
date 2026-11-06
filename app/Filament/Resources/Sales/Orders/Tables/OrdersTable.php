<?php

namespace App\Filament\Resources\Sales\Orders\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total')
                    ->money('USD', divideBy: 100)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('M j, Y H:i')
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('canceled_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
