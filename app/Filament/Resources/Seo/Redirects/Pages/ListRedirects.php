<?php

namespace App\Filament\Resources\Seo\Redirects\Pages;

use App\Filament\Resources\Seo\Redirects\RedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
