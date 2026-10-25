<?php

namespace App\Filament\Resources\Catalog\Products\Schemas;

use App\Enums\DiscountType;
use App\Filament\Forms\FieldGroups\ImageFieldset;
use App\Filament\Forms\Fields\EditorFields\SeoEditor;
use App\Filament\Forms\Fields\ImageFields\GalleryPicker;
use App\Filament\Forms\Fields\TextFields\NameInput;
use App\Filament\Forms\Fields\TextFields\PriceInput;
use App\Filament\Forms\Fields\ToggleFields\FeaturedToggle;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use App\Filament\Forms\Layouts\Tabs\StatusTab;
use App\Filament\Resources\Catalog\Products\RelationManagers\PromotionsRelationManager;
use App\Models\Catalog\Product;
use App\Models\Filters\Attribute;
use App\Models\Filters\AttributeValue;
use App\Support\ContentLocale;
use Closure;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Njxqlus\Filament\Components\Forms\RelationManager;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    Tab::make('Content')->schema([
                        Grid::make(3)->schema([
                            NameInput::make()->columnSpanFull(),
                            TextInput::make('sku')->required()->unique(ignoreRecord: true),
                            PriceInput::make(),
                            TextInput::make('stock_qty')
                                ->label('Stock quantity')
                                ->numeric()
                                ->integer()
                                ->minValue(0)
                                ->default(0)
                                ->required(),
                        ]),
                        SeoEditor::make('short_description')->label('Short description'),
                        SeoEditor::make('description')->label('Description'),
                        ImageFieldset::wrap(GalleryPicker::make()->directory('products')),
                    ]),
                    Tab::make('Relationships')
                        ->schema([
                            // categories
                            Select::make('category_id')
                                ->relationship('categories', 'name')
                                ->multiple()
                                ->preload()
                                ->optionsLimit(25)
                                ->live(),
                            // brands
                            Select::make('brand_id')
                                ->relationship('brand', 'name')
                                ->preload()
                                ->searchable()
                                ->optionsLimit(25)
                                ->live(),
                        ]),
                    Tab::make('Properties')
                        ->visible(fn (Get $get): bool => filled($get('category_id')) || filled($get('brand_id')))
                        ->schema([self::attributeRepeater()])
                        ->hiddenOn('create'),
                    Tab::make('Discounts')
                        ->schema([
                            Toggle::make('is_discounted')
                                ->label('Discounted')
                                ->default(false)
                                ->live()
                                ->afterStateUpdated(function (bool $state, Set $set, $livewire, string $operation) {
                                    if ($state && $operation === 'edit') {
                                        $set('is_discounted', false);
                                        $livewire->mountAction('enableDiscount');
                                    }
                                }),
                            Group::make()
                                ->visible(fn (Get $get): bool => (bool) $get('is_discounted'))
                                ->schema([
                                    Select::make('discount_type')
                                        ->options(collect(DiscountType::cases())
                                            ->mapWithKeys(fn (DiscountType $type
                                            ) => [$type->value => Str::headline($type->name)])
                                            ->all())
                                        ->required(),
                                    PriceInput::make('discount_price'),
                                ]),
                        ]),
                    Tab::make('Promotions')
                        ->visible(fn (
                            Get $get,
                            ?Product $record
                        ): bool => ! $get('is_discounted') && $record?->promotions()->exists())
                        ->schema([
                            RelationManager::make()
                                ->manager(PromotionsRelationManager::class)
                                ->lazy(false),
                        ]),
                    SeoTab::make(),
                    StatusTab::make()->append([FeaturedToggle::make()]),
                ]),
            ])
            ->columns(1);
    }

    /**
     * Each row is one property: an attribute applicable to the selected
     * categories/brand plus one of its values. Persisted in EditProduct::afterSave().
     */
    protected static function attributeRepeater(): Repeater
    {
        return Repeater::make('filter_values')
            ->label('Properties')
            ->addActionLabel('Add property')
            ->addable(fn (Get $get): bool => count($get('filter_values') ?? []) < count(self::applicableAttributes(
                $get('category_id') ?? [],
                $get('brand_id'),
            )))
            ->defaultItems(0)
            ->columns(2)
            ->dehydrated(false)
            ->schema([
                Select::make('attribute_id')
                    ->label('Attribute')
                    ->options(fn (Get $get): array => self::applicableAttributes(
                        $get('../../category_id') ?? [],
                        $get('../../brand_id'),
                    ))
                    ->required()
                    ->live()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->afterStateUpdated(fn (Set $set) => $set('value_id', null)),
                Select::make('value_id')
                    ->label('Value')
                    ->options(fn (Get $get) => AttributeValue::query()
                        ->where('attribute_id', $get('attribute_id'))
                        ->pluck('value', 'id'))
                    ->required()
                    ->disabled(fn (Get $get): bool => blank($get('attribute_id')))
                    ->createOptionForm([
                        TextInput::make('value')
                            ->required()
                            ->rules([
                                fn (Get $get): Closure => function (
                                    string $field,
                                    $value,
                                    Closure $fail
                                ) use ($get) {
                                    $slug = Str::slug($value, language: ContentLocale::get());
                                    $attribute = Attribute::find($get('../attribute_id'));

                                    if ($attribute?->values()->where('slug', $slug)->exists()) {
                                        $fail("{$attribute->name} already has the value \"{$value}\".");
                                    }
                                },
                            ]),
                    ])
                    ->createOptionUsing(fn (
                        array $data,
                        Get $get
                    ) => Attribute::findOrFail($get('attribute_id'))
                        ->values()
                        ->create($data)
                        ->getKey()),
            ]);
    }
    /**
     * @param  array<int, int|string>  $categoryIds
     * @return array<int, string>
     */
    protected static function applicableAttributes(array $categoryIds, $brandId): array
    {
        return Attribute::query()
            ->whereHas('categories', fn (Builder $q) => $q->whereKey($categoryIds))
            ->orWhereHas('brands', fn (Builder $q) => $q->whereKey($brandId))
            ->get()
            ->mapWithKeys(fn (Attribute $attribute) => [$attribute->id => $attribute->name])
            ->all();
    }
}
