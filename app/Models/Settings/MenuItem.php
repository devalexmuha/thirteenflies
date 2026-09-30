<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    /** @use HasFactory<\Database\Factories\Settings\MenuItemFactory> */
    use HasFactory, HasTranslations;

    public $timestamps = false;

    public array $translatable = ['label'];

    protected $guarded = [];

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }
}
