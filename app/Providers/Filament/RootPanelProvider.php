<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\DashboardStatsOverview; // <-- Importa tu widget de estadísticas
use Filament\Http\Middleware\Authenticate;
// use Filament\Http\Middleware\AuthenticateSession; // <-- Comentado o eliminado si no se usa explícitamente aquí
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets; // <-- Importa el namespace de Widgets
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession; // <-- Asegúrate que esté aquí si lo necesitas
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

// Asegúrate que el nombre de la clase coincida con tu archivo: RootPanelProvider
class RootPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('root') // ID de tu panel
            ->path('root') // Ruta de tu panel
            ->login()
            ->colors([
                'primary' => Color::Amber,
                'danger' => '#FF0000', // Color para botones de eliminación
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                // Widgets por defecto (puedes mantenerlos o comentarlos si no los quieres)
                 Widgets\AccountWidget::class,
                 Widgets\FilamentInfoWidget::class,

                 // --- REGISTRA TU WIDGET AQUÍ ---
                 DashboardStatsOverview::class, // <-- Añadido tu widget de estadísticas

                 // Puedes añadir más widgets personalizados aquí:
                 // App\Filament\Widgets\OtroWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class, // Middleware de sesión
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class, // Middleware de autenticación de Filament
            ])
            ->darkMode(true, true);
    }
}
