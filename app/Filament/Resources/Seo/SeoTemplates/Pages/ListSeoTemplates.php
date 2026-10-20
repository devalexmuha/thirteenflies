<?php

namespace App\Filament\Resources\Seo\SeoTemplates\Pages;

use App\Enums\SeoTemplateType;
use App\Filament\Resources\Seo\SeoTemplates\SeoTemplateResource;
use App\Models\Seo\SeoTemplate;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeoTemplates extends ListRecords
{
    protected static string $resource = SeoTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    public function mount(): void
    {
        SeoTemplate::query()->insertOrIgnore(
            collect(SeoTemplateType::cases())
                ->map(fn (SeoTemplateType $type) => [
                    'page_type' => $type->value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
                ->all()
        );

        parent::mount();
    }
}
