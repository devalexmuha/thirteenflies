<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Pages;

use App\Filament\Resources\Catalog\FilterAttributes\FilterAttributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilterAttributes extends ListRecords
{
    protected static string $resource = FilterAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
