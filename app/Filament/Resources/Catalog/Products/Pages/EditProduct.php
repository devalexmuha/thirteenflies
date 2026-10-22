<?php

namespace App\Filament\Resources\Catalog\Products\Pages;

use App\Enums\DiscountType;
use App\Filament\Resources\Catalog\Products\ProductResource;
use App\Models\Catalog\Discount;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return "Edit '{$this->getRecord()->name}' ".ucfirst(static::getResource()::getModelLabel());
    }

    public function enableDiscountAction(): Action
    {
        return Action::make('enableDiscount')
            ->requiresConfirmation()
            ->modalHeading('Are you sure?')
            ->modalDescription('All discounted products automatically get removed from all their promotions.')
            ->action(function (): void {
                $this->record->promotions()->detach();
                $this->data['is_discounted'] = true;
            });
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['discount_type'] = $this->record->discount?->type;

        $data['filter_values'] = [];

        foreach ($this->record->attributeValues as $value) {
            $data['filter_values'][] = [
                'attribute_id' => $value->attribute_id,
                'value_id' => $value->id,
            ];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['is_discounted']) {
            $type = DiscountType::from($data['discount_type']);

            $discount = Discount::firstOrCreate(
                ['type' => $type->value],
                ['name' => Str::headline($type->name)],
            );

            $data['discount_id'] = $discount->id;
        } else {
            $data['discount_id'] = null;
            $data['discount_price'] = null;
        }

        unset($data['discount_type'], $data['filter_values']);

        return $data;
    }

    protected function afterSave(): void
    {
        $ids = collect($this->data['filter_values'] ?? [])
            ->pluck('value_id')
            ->filter()
            ->all();

        $this->record->attributeValues()->sync($ids);
    }
}
