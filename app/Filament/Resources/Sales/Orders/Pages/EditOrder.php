<?php

namespace App\Filament\Resources\Sales\Orders\Pages;

use App\Filament\Resources\Sales\Orders\OrderResource;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTitle(): string
    {
        return "Edit '{$this->getRecord()->number}' ".ucfirst(static::getResource()::getModelLabel());
    }
}
