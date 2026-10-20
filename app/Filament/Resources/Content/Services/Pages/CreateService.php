<?php

namespace App\Filament\Resources\Content\Services\Pages;

use App\Filament\Resources\Content\Services\ServiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['name'] ??= $this->data['seoMeta']['h1'];

        return $data;
    }
}
