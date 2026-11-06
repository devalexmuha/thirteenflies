<?php

namespace App\Filament\Widgets;

use App\Models\Sales\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalRevenueStats extends StatsOverviewWidget
{

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Revenue Today (USD)',
                number_format(Order::whereDate('created_at', date('Y-m-d'))->sum('total') / 100, 2)),
            Stat::make('Revenue Last 7 Days (USD)',
                number_format(Order::where('created_at', '>=', now()->subDays(7)->startOfDay())->sum('total') / 100, 2)),
            Stat::make('Revenue Last 30 Days (USD)',
                number_format(Order::where('created_at', '>=', now()->subDays(30)->startOfDay())->sum('total') / 100, 2))
        ];
    }
}
