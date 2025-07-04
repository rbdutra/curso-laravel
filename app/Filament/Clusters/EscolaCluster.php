<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class EscolaCluster extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel = 'Escola';
    protected static ?string $modelLabel = 'Escola ';
    protected static ?string $pluralModelLabel = 'Escola';
    protected static ?int $navigationSort = 1;
}
