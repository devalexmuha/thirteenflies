<?php

namespace App\Filament\Resources\Seo\FilterPages\Pages;

use App\Filament\Resources\Seo\FilterPages\FilterPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilterPages extends ListRecords
{
    protected static string $resource = FilterPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
