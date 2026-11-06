<?php

namespace App\Filament\Resources\Sales\Orders\Pages;

use App\Filament\Resources\Sales\Orders\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
