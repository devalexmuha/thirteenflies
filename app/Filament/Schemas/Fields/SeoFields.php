<?php

namespace App\Filament\Schemas\Fields;

use App\Models\Seo\Slug;
use App\Support\ContentLocale;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;
use InvalidArgumentException;

class SeoFields
{
    public static function make(array $fields): array
    {
        $result = [];

        foreach ($fields as $field) {
            if ($field === 'make' || ! method_exists(self::class, $field)) {
                throw new InvalidArgumentException("Unknown SEO field: {$field}");
            }

            $result[] = self::$field();
        }

        return $result;
    }

    public static function h1(): TextInput
    {
        return TextInput::make('h1')->columnSpan(2);
    }

    private static function title(): TextInput
    {
        return TextInput::make('meta_title')->columnSpanFull();
    }

    private static function description(): Textarea
    {
        return Textarea::make('meta_description')->columnSpanFull();
    }

    private static function robots(): Select
    {
        return Select::make('robots')
                     ->options([
                         'index, follow'     => 'index, follow',
                         'noindex, follow'   => 'noindex, follow',
                         'noindex, nofollow' => 'noindex, nofollow',
                     ])
                     ->default('index, follow')
                     ->selectablePlaceholder(false);
    }

    private static function slug(): TextInput
    {
        return TextInput::make('slug')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, $set) => $set('slug',
                            Str::slug($state, '-', ContentLocale::get())))
                        ->unique(
                            table: Slug::class,
                            column: 'slug',
                            ignoreRecord: true,
                            modifyRuleUsing: fn(Unique $rule, $livewire) => $rule
                                ->where('locale', ContentLocale::get())
                                ->where('sluggable_type', $livewire->getModel()),
                        )->required();
    }
}
