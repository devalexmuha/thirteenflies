<?php

namespace App\Filament\Resources\Catalog\Discounts\Pages;

use App\Filament\Resources\Catalog\Discounts\DiscountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDiscounts extends ListRecords
{
    protected static string $resource = DiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }
}
