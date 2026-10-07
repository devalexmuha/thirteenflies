<?php

namespace App\Filament\Resources\Catalog\FilterAttributeValues\Pages;

use App\Filament\Resources\Catalog\FilterAttributeValues\FilterAttributeValueResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilterAttributeValues extends ListRecords
{
    protected static string $resource = FilterAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
