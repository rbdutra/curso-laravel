<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            Stat::make('Alunos', '10.235')
                ->description('Alunos')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Cursos', '1.220')
                ->description('Cursos')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Matrículas', '10.012')
                ->description('Matrículas')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
