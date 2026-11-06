<?php

namespace App\Filament\Widgets;

use App\Models\Sales\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersPerDayChart extends ChartWidget
{
    protected ?string $heading = 'Orders Per Day';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '300px';

    protected ?string $pollingInterval = '60s';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = Trend::model(Order::class)
                     ->between(
                         start: now()->subDays(30),
                         end: now(),
                     )
                     ->perDay()
                     ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Orders per day',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
