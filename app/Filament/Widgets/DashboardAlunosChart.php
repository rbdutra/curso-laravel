<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DashboardAlunosChart extends ChartWidget
{
    protected static ?string $heading = 'Alunos por cidade';
    protected static ?int $sort = 2;

    protected function getData(): array
    {

        return [
            'datasets' => [
                [
                    'label' => 'Alunos por cidade',
                    'data' => [500, 100, 51, 200, 210],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(155, 205, 86)',
                        'rgb(55, 10, 106)',
                    ],
                ],
            ],
            'labels' => ['Vitória', 'Vila Velha', 'Serra', 'Cariacica', 'Viana'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
