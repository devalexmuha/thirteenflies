<?php

namespace App\Filament\Resources\Catalog\Brands\Pages;

use App\Filament\Resources\Catalog\Brands\BrandResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Edit '{$this->getRecord()->name}' " . ucfirst(static::getResource()::getModelLabel());
    }

}
