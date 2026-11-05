<?php

namespace App\Filament\Resources\Sales\Customers\Pages;

use App\Filament\Resources\Sales\Customers\CustomerResource;
use Filament\Resources\Pages\ViewRecord;

class ViewCustomer extends ViewRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
