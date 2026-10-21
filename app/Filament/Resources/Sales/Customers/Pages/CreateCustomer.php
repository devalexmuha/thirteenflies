<?php

namespace App\Filament\Resources\Sales\Customers\Pages;

use App\Filament\Resources\Sales\Customers\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
