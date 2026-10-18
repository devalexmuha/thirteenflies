<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;

/**
 * Save button for resource Create/Edit pages (e.g. in a sidebar).
 * SaveAction::make()
 */
class SaveAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'save';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Save')
             ->action(fn ($livewire) => $livewire instanceof CreateRecord
                 ? $livewire->create()
                 : $livewire->save());
    }
}
