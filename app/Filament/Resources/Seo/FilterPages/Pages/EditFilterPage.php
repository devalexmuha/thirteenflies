<?php

namespace App\Filament\Resources\Seo\FilterPages\Pages;

use App\Filament\Resources\Seo\FilterPages\FilterPageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFilterPage extends EditRecord
{
    protected static string $resource = FilterPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        $record = $this->getRecord();
        $title = $record->seoMeta?->h1;

        return "Edit '{$title}' " . ucfirst(static::getResource()::getModelLabel());
    }
}
