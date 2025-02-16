<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\NavigationItem;

class FrontendPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $menu = [];

        foreach (config("flow.menu.default") as $key => $value) {
            $item = NavigationItem::make($key);
            $item->label($value["label"]);
            $item->url($value["url"]);
            $item->isActiveWhen(
                fn() => request()->is(substr($value["url"], 1))
            );
            $menu[] = $item;
        }

        return $panel
            ->id("frontend")
            ->path("/")
            ->colors([
                "primary" => Color::Amber,
            ])
            ->discoverResources(
                in: app_path("Filament/Frontend/Resources"),
                for: "App\\Filament\\Frontend\\Resources"
            )
            ->discoverPages(
                in: app_path("Filament/Frontend/Pages"),
                for: "App\\Filament\\Frontend\\Pages"
            )
            ->pages([])
            ->discoverWidgets(
                in: app_path("Filament/Frontend/Widgets"),
                for: "App\\Filament\\Frontend\\Widgets"
            )
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->navigationItems($menu)
            ->topNavigation();
    }
}
