<?php

namespace App\Filament\Resources\Catalog\FilterAttributeValues\Pages;

use App\Filament\Resources\Catalog\FilterAttributeValues\FilterAttributeValueResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilterAttributeValue extends EditRecord
{
    protected static string $resource = FilterAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
