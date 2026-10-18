<?php

namespace App\Filament\Forms\Layouts\Tabs;

use App\Filament\RelationManagers\FilterAttributesRelationManager;
use Njxqlus\Filament\Components\Forms\RelationManager;

/**
 * AttributesTab::make()  — hidden on create (the record must exist first).
 */
class AttributesTab extends FormTab
{
    protected static function defaultLabel(): string
    {
        return 'Attributes';
    }

    protected function defaultSchema(): array
    {
        return [
            RelationManager::make()
                           ->manager(FilterAttributesRelationManager::class)
                           ->lazy(false),
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hiddenOn('create');
    }
}
