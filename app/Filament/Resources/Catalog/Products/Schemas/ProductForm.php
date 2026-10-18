<?php

namespace App\Filament\Resources\Catalog\Products\Schemas;

use App\Enums\DiscountType;
use App\Filament\Forms\Blocks\SeoContentBlock;
use App\Filament\Forms\FieldGroups\ImageFieldset;
use App\Filament\Forms\Fields\EditorFields\SeoEditor;
use App\Filament\Forms\Fields\ImageFields\FeaturedImagePicker;
use App\Filament\Forms\Fields\ImageFields\GalleryPicker;
use App\Filament\Forms\Fields\ImageFields\MainBannerPicker;
use App\Filament\Forms\Fields\TextFields\NameInput;
use App\Filament\Forms\Fields\ToggleFields\FeaturedToggle;
use App\Filament\Forms\Layouts\Tabs\SeoTab;
use App\Filament\Forms\Layouts\Tabs\StatusTab;
use App\Filament\Resources\Catalog\Products\RelationManagers\PromotionsRelationManager;
use App\Filament\Schemas\Panels\FormTabs;
use App\Models\Catalog\Product;
use App\Models\Filters\Attribute;
use App\Support\ContentLocale;
use Closure;
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
                        Grid::make()->schema([
                            NameInput::make()->columnSpanFull(),
                            TextInput::make('sku')->required()->unique(ignoreRecord: true),
                            TextInput::make('price')->numeric()->prefix('$')->required(),
                        ]),
                        SeoEditor::make('short_description')->label('Short description'),
                        SeoEditor::make('description')->label('Description'),
                        ImageFieldset::wrap(GalleryPicker::make()->directory('Products')),
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
                       ->visible(fn(Get $get): bool => filled($get('category_id')) || filled($get('brand_id')))
                       ->schema(fn(Get $get): array => self::attributeFields($get('category_id') ?? [],
                           $get('brand_id')))->hiddenOn('create'),
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
                                ->visible(fn(Get $get): bool => (bool) $get('is_discounted'))
                                ->schema([
                                    Select::make('discount_type')
                                          ->options(collect(DiscountType::cases())
                                              ->mapWithKeys(fn(DiscountType $type
                                              ) => [$type->value => Str::headline($type->name)])
                                              ->all())
                                          ->required(),
                                    TextInput::make('discount_price')
                                             ->numeric()
                                             ->prefix('$')
                                             ->required(),
                                ]),
                       ]),
                    Tab::make('Promotions')
                       ->visible(fn(
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
                ])
            ])
            ->columns(1);
    }

    protected static function attributeFields(array $categoryIds, $brandId): array
    {
        $attributes = Attribute::query()
                               ->whereHas('categories', fn(Builder $q) => $q->whereKey($categoryIds))
                               ->orWhereHas('brands', fn(Builder $q) => $q->whereKey($brandId))
                               ->with('values')
                               ->get();

        $fields = [];

        foreach ($attributes as $attribute) {
            $fields[] = Select::make("filter_values.{$attribute->id}")
                              ->label($attribute->name)
                              ->options($attribute->values->pluck('value', 'id'))
                              ->createOptionForm([
                                  TextInput::make('value')
                                           ->required()
                                           ->rules([
                                               fn(): Closure => function (string $field, $value, Closure $fail) use (
                                                   $attribute
                                               ) {
                                                   $slug = Str::slug($value, language: ContentLocale::get());

                                                   if ($attribute->values()->where('slug', $slug)->exists()) {
                                                       $fail("{$attribute->name} already has the value \"{$value}\".");
                                                   }
                                               },
                                           ]),
                              ])
                              ->createOptionUsing(fn(array $data) => $attribute->values()->create($data)->getKey())
                              ->dehydrated(false);
        }

        return $fields;
    }
}
