<?php

namespace App\Filament\Resources\Catalog\FilterAttributes\Pages;

use App\Filament\Resources\Catalog\FilterAttributes\FilterAttributeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilterAttribute extends EditRecord
{
    protected static string $resource = FilterAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
