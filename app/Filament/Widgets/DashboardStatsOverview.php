<?php

namespace App\Filament\Widgets;

use App\Models\Eventos; // Importa el modelo Eventos
use App\Models\Pilotos; // Importa el modelo Pilotos
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Tarjeta para mostrar el número total de pilotos
            Stat::make('Total Pilotos', Pilotos::count()) // Etiqueta y valor (conteo de modelos)
                ->description('Número de pilotos registrados') // Descripción opcional
                ->descriptionIcon('heroicon-m-user-group') // Icono opcional
                ->color('success'), // Color opcional (success, warning, danger, primary, etc.)
                // ->chart([7, 2, 10, 3, 15, 4, 17]) // Gráfico pequeño opcional

            // Tarjeta para mostrar el número total de eventos
            Stat::make('Total Eventos', Eventos::count())
                ->description('Número de eventos creados')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
                // ->chart([1, 5, 2, 8, 3, 9, 4])

            // Puedes añadir más tarjetas aquí...
            // Stat::make('Registros Hoy', EventoPiloto::whereDate('created_at', today())->count()),
        ];
    }
}
