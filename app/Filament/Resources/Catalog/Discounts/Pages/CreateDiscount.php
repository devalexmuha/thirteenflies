<?php

namespace App\Filament\Resources\Catalog\Discounts\Pages;

use App\Filament\Resources\Catalog\Discounts\DiscountResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDiscount extends CreateRecord
{
    protected static string $resource = DiscountResource::class;
}
