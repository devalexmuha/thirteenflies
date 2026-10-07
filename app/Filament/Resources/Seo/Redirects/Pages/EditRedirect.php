<?php

namespace App\Filament\Resources\Seo\Redirects\Pages;

use App\Filament\Resources\Seo\Redirects\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
