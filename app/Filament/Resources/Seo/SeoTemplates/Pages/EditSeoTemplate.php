<?php

namespace App\Filament\Resources\Seo\SeoTemplates\Pages;

use App\Filament\Resources\Seo\SeoTemplates\SeoTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeoTemplate extends EditRecord
{
    protected static string $resource = SeoTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function getTitle(): string
    {
        return "Edit '" . $this->getRecord()->page_type->getLabel() . "' " . ucfirst(static::getResource()::getModelLabel());
    }
}
