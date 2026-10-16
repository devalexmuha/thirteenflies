<?php

namespace App\Filament\Resources\Catalog\Discounts\Pages;

use App\Filament\Resources\Catalog\Discounts\DiscountResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDiscount extends EditRecord
{
    protected static string $resource = DiscountResource::class;

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
