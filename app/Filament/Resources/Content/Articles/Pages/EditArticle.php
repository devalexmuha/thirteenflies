<?php

namespace App\Filament\Resources\Content\Articles\Pages;

use App\Filament\Resources\Content\Articles\ArticleResource;
use App\Support\ContentLocale;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        return "Edit '{$this->getRecord()->name}' " . ucfirst(static::getResource()::getModelLabel());
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $name = $this->record->getTranslation('name', ContentLocale::get(), false);

        if (blank($name)) {
            $data['name'] = $this->data['seoMeta']['h1'];
        }

        return $data;
    }
}
