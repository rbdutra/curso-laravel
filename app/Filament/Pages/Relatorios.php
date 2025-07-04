<?php

namespace App\Filament\Pages;

use App\Models\Aluno;
use App\Models\Curso;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;

class Relatorios extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Relatório';
    protected static ?string $modelLabel = 'Relatório ';
    protected static ?string $pluralModelLabel = 'Relatório';
    protected static ?int $navigationSort = 4;
    protected static string $view = 'filament.pages.relatorios';

    public ?array $reportData = [];

    public function mount(): void
    {
        $this->reportForm->fill();
    }
    protected function getForms(): array
    {
        return [
            'reportForm',
        ];
    }
    public function reportForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Relatório')
                    ->description('Relatório Gerais')
                    ->schema([
                        Forms\Components\Radio::make('relatorio')
                            ->label('Relatório')
                            ->options([
                                1 => 'Cursos do Aluno',
                                2 => 'Alunos do Curso',
                                3 => 'Inscrições realizadas no período',
                            ])
                            ->inline()
                            ->inlineLabel(false)
                            ->default(1)
                            ->live()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('aluno_id')
                            ->label('Alunos')
                            ->options(
                                Aluno::all()->pluck('nome', 'id')
                            )
                            ->hidden(fn(Get $get) => ($get('relatorio') != 1))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->columnSpan(4),

                        Forms\Components\Select::make('curso_id')
                            ->label('Cursos')
                            ->options(
                                Curso::all()->pluck('nome', 'id')
                            )
                            ->hidden(fn(Get $get) => ($get('relatorio') != 2))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->columnSpan(4),

                        Forms\Components\DatePicker::make('inicio')
                            ->label('Início')
                            ->live()
                            ->hidden(fn(Get $get) => ($get('relatorio') != 3)),

                        Forms\Components\DatePicker::make('termino')
                            ->label('Término')
                            ->live()
                            ->hidden(fn(Get $get) => ($get('relatorio') != 3)),
                    ])
                    ->columns(8),
            ])
            ->statePath('reportData');
    }

    public function getFormActions(): array
    {
        return [
            Action::make('enviar')
                ->label('Imprimir')
                ->icon('heroicon-o-printer')
                ->url(function (): string {
                    $link = '';
                    switch ($this->reportData['relatorio']) {
                        case 1:
                            $aluno_id = 0;
                            if ($this->reportData['aluno_id'])
                                $aluno_id = $this->reportData['aluno_id'];

                            $link = route('relatorio.cursosdoaluno', ['aluno_id' => $aluno_id]);
                            break;
                        case 2:
                            $curso_id = 0;
                            if ($this->reportData['curso_id'])
                                $curso_id = $this->reportData['curso_id'];

                            $link = route('relatorio.alunosdocurso', ['curso_id' => $curso_id]);
                            break;
                        case 3:
                            $inicio = 0;
                            if ($this->reportData['inicio'])
                                $inicio = $this->reportData['inicio'];
                            $termino = 0;
                            if ($this->reportData['termino'])
                                $termino = $this->reportData['termino'];

                            $link = route('relatorio.inscricaoperiodo', ['inicio' => $inicio, 'termino' => $termino]);
                    }
                    return $link;
                }, true),
        ];
    }
}
