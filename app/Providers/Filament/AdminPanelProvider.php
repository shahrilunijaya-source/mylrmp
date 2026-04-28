<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login as CustomLogin;
use App\Filament\Widgets\ApplicationsByStageChart;
use App\Filament\Widgets\ApplicationsTimelineChart;
use App\Filament\Widgets\KpiOverviewWidget;
use App\Filament\Widgets\RecentActivitiesWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(CustomLogin::class)
            ->registration(false)
            ->brandName('myLRMP')
            ->brandLogoHeight('2rem')
            ->favicon(asset('favicon.png'))
            ->colors([
                'primary' => Color::hex('#006837'),
                'warning' => Color::hex('#FFCC00'),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->userMenu(false)
            ->renderHook(
                PanelsRenderHook::SIDEBAR_FOOTER,
                fn () => view('filament.hooks.sidebar-footer'),
            )
            ->navigationGroups([
                'Permohonan',
                'Pengurusan',
                'Maklumat Rujukan',
                'Laporan & Audit',
                'Pentadbiran',
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                KpiOverviewWidget::class,
                ApplicationsByStageChart::class,
                ApplicationsTimelineChart::class,
                RecentActivitiesWidget::class,
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
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
