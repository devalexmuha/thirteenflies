<?php

namespace App\Filament\Widgets;

use App\Models\Sales\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestOrders extends TableWidget
{

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Order::query()->latest()->limit(5))
            ->paginated(false)
            ->poll('60s')
            ->columns([
                TextColumn::make('number'),
                TextColumn::make('payment_status')
                          ->badge(),
                TextColumn::make('status')
                          ->badge(),
                TextColumn::make('email')
                          ->label('Email address'),
                TextColumn::make('total')
                          ->money('USD', divideBy: 100),
                TextColumn::make('created_at')
                          ->dateTime('M j, Y H:i'),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
