# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

"Thirteen Flies" — a multilingual e-commerce + content backend on Laravel 13 / PHP 8.4+. It has two faces:
- **Filament 5 admin panel** at `/admin` (the bulk of the code so far).
- **JSON API** under `/api/*` (in progress on `building-api-end-points`), meant to be consumed by a separate Next.js frontend. `routes/api.php` also holds the author's running TODO list as comments — read it for planned work.

## Commands

```sh
composer setup            # first-time: install, .env, key, migrate, npm install + build
composer dev              # artisan serve + queue:listen + vite, concurrently
composer test             # config:clear + artisan test (Pest)
php artisan test --filter=SomeTest            # single test
php artisan test tests/Feature/ExampleTest.php
vendor/bin/pint           # format (Laravel Pint); --dirty for changed files only
php artisan migrate:fresh --seed              # DB seeder only seeds SeoTemplates
```

- Default DB is SQLite (`database/database.sqlite`); tests use in-memory SQLite with a sync queue (`phpunit.xml`).
- `QUEUE_CONNECTION=database`: uploaded media is compressed by a queued job, so a queue worker must be running (`composer dev` starts one).
- `spatie/laravel-settings` migrations live in `database/settings/`, not `database/migrations/`.
- `composer dump-autoload` triggers `filament:upgrade`; `composer update` triggers `boost:update`.

## Architecture

### Domain layout
Models, Filament resources, and factories are grouped by domain namespace: `Catalog`, `Content`, `Sales`, `Seo`, `Filters`, `Account`, `Access` (e.g. `App\Models\Catalog\Product`, `App\Filament\Resources\Catalog\Products\…`). Factories in `database/factories` mirror the model domain folders (e.g. `Database\Factories\Catalog\ProductFactory`), so Laravel's default factory guessing resolves them. `MediaFactory`, `MenuFactory` and `MenuItemFactory` are leftover stubs at the root with no matching model.

### Shared model traits (`app/Models/Traits`)
Most content/catalog models compose the same polymorphic features:
- `Translatable` — wraps spatie/laravel-translatable; translatable columns are JSON keyed by locale and listed in `$translatable`. Overrides `attributesToArray()` so serialization returns the current-locale string, not the full JSON. Fallback locale is `en` (any locale as last resort).
- `HasSlug` — `slugs` table holds **one row per locale** (`sluggable` morph). `slug()` is scoped to the current locale; `Slug` normalizes with `Str::slug` on save.
- `HasSeoMeta` — `morphOne` `SeoMeta` (`seoable`).
- `HasMedia` — Curator `Media` via `mediables` pivot with `order`, `locale`, `image_type` columns; `mainBanner()` / `featuredImage()` filter by `image_type` (see `App\Enums\ImageType`).
- `HasFilterAttributes` — `morphToMany` filter `Attribute`s (`attributables`).

Traits clean up their related rows in `deleting` hooks; delete models through Eloquent (not query-builder deletes) to keep that working. `Category` is a nested-set tree (`kalnoy/nestedset`).

### Locale resolution — important
`App\Support\ContentLocale::get()` is the single source of the "current content locale" and is used by the traits above. It returns `session('admin_locale')` if set (admin locale switcher route `admin/locale/{locale}` in `AdminPanelProvider`), else `app()->getLocale()`. For the API, `SetLocale` middleware sets the app locale from `?locale=` (default `en`, 422 on invalid). Supported locales are the `App\Enums\Locale` enum (en, es, uk, ru).

### Global middleware / API behavior
`bootstrap/app.php` prepends `AcceptOnlyJson` (forces `Accept: application/json` on `api/*`) and `SetLocale`, and renders 404s as JSON for JSON requests. API controllers live in `App\Http\Controllers\Api` and return `App\Http\Resources\*` API resources.

### Filament admin
- Resources are auto-discovered from `app/Filament/Resources`. Each resource follows Filament's split layout: `XResource.php` + `Pages/` + `Schemas/XForm.php` + `Tables/XTable.php`. Navigation groups: Catalog, ContentLayouts, SEO, Sales, Settings.
- **Reusable form/table building blocks** in `app/Filament/Forms` (Fields, FieldGroups, Blocks, Layouts/Tabs, Layouts/Sections) and `app/Filament/Tables` (Columns, Filters, Presets). These are subclasses of Filament components that preconfigure themselves in `setUp()` / `getDefaultName()` (e.g. `NameInput`, `SlugGroup` bound to the `slug` relationship, `SeoTab`, `StatusTab`, `ImageFieldset::wrap(...)`). Prefer composing these over configuring raw Filament components in resource schemas.
- Media management uses the Curator plugin; new `Media` records dispatch `CompressMedia` (→ `App\Services\ImageCompressor`).
- Site-wide settings (`App\Settings\ContactSettings`, `MenuSettings`) are edited via `app/Filament/Pages/Manage*.php`.
- Admin theme: `resources/css/filament/admin/theme.css` (Vite, Tailwind 4).

## Laravel Boost guidelines

Generated by Laravel Boost (`php artisan boost:update` regenerates it); domain skills live in `.claude/skills/`.

@AGENTS.md
