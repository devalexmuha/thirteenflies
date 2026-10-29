<?php

namespace App\Filament\Resources\Content\Authors\Pages;

use App\Filament\Resources\Content\Authors\AuthorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    protected static string $resource = AuthorResource::class;

    protected function getFormActions(): array
    {
        return [];
    }
}
