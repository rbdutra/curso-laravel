<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DashboardMatriculasChart extends ChartWidget
{
    protected static ?string $heading = 'Matrículas por mês';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Matriculas por mês',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(155, 205, 86)',
                        'rgb(55, 10, 106)',
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(155, 205, 86)',
                        'rgb(55, 10, 106)',
                    ],
                ],
            ],
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
