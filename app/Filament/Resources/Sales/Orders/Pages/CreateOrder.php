<?php

namespace App\Filament\Resources\Sales\Orders\Pages;

use App\Filament\Resources\Sales\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
