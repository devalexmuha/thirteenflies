<?php

namespace App\Filament\Resources\Content\Authors\Pages;

use App\Filament\Resources\Content\Authors\AuthorResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{
    protected static string $resource = AuthorResource::class;

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
