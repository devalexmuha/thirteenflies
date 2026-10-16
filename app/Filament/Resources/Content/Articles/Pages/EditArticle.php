<?php

namespace App\Filament\Resources\Content\Articles\Pages;

use App\Filament\Resources\Content\Articles\ArticleResource;
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

    public function getTitle(): string
    {
        return "Edit '{$this->getRecord()->name}' " . ucfirst(static::getResource()::getModelLabel());
    }
}
