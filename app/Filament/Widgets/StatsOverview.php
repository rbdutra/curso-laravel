<?php

namespace App\Filament\Widgets;

use App\Models\Aluno;
use App\Models\Curso;
use App\Models\Inscricao;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $alunos = Aluno::count();
        $cursos = Curso::count();
        $inscricoes = Inscricao::count();

        return [
            Stat::make('Alunos', $alunos)
                ->description('Alunos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->extraAttributes([
                    'class' => 'shadow-lg shadow-red-600 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                ]),

            Stat::make('Cursos', $cursos)
                ->description('Cursos')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning')
                ->chart([10, 3, 15, 4, 17]),

            Stat::make('Matrículas', $inscricoes)
                ->description('Matrículas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('danger')
                ->chart([15, 4, 17]),
        ];
    }
}
