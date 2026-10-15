<?php

namespace App\Providers\Filament;

use App\Enums\Locale;
use App\Http\Middleware\SetAdminLocale;
use Awcodes\Curator\CuratorPlugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->login()
            ->brandName('Thirteen Flies')
            ->favicon(asset('images/fly-shape.png'))
            ->colors([
                'primary' => '#006039',
                'success' => '#006039',
                'info'    => '#006039',
                'danger'  => '#B40610',
                'warning' => '#B40610',
                'gray'    => Color::Neutral,
            ])
            ->font('Crimson Pro', provider: GoogleFontProvider::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authenticatedRoutes(function () {
                Route::get('/locale/{locale}', function (string $locale) {

                    abort_unless((bool) Locale::tryFrom($locale), 404);
                    session(['admin_locale' => $locale]);

                    return back();

                })->name('locale');
            })
            ->renderHook(PanelsRenderHook::USER_MENU_BEFORE, fn() => view('filament.locale-switcher'))
            ->navigationGroups([
                NavigationGroup::make('Catalog'),
                NavigationGroup::make('Content'),
                NavigationGroup::make('SEO')
                               ->collapsed(),
                NavigationGroup::make('Settings')
                               ->collapsed(),
            ])->plugins(
                [
                    CuratorPlugin::make()
                                 ->label('Media')
                                 ->pluralLabel('Media Library')
                                 ->navigationGroup('Settings')
                                 ->navigationIcon('heroicon-o-photo'),
                ]
            );
    }
}
