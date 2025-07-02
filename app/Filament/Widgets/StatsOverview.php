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
    protected function getStats(): array
    {
        $alunos = Aluno::count();
        $cursos = Curso::count();
        $inscricoes = Inscricao::count();

        return [
            Stat::make('Alunos', $alunos)
                ->description('Alunos')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Cursos', $cursos)
                ->description('Cursos')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

            Stat::make('Matrículas', $inscricoes)
                ->description('Matrículas')
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
        ];
    }
}
