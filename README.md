# Curso Desenvolvimento Web Ágil

## Laravel, Livewire, Alpins.js, Filament e tailwindcss

### Instalação

-   **[XAMPP](https://www.apachefriends.org/pt_br/download.html)**
-   **[VSCode](https://code.visualstudio.com/download)**
-   **[DBeaver](https://dbeaver.io/download)**

### Documentação

-   **[PHP 8+](https://www.php.net/manual/en)**
-   **[MYSQL 5+](https://dev.mysql.com/doc)**
-   **[Laravel 11+](https://laravel.com/docs/11.x)**
-   **[Composer](https://getcomposer.org/doc)**
-   **[Livewire 3+](https://livewire.laravel.com/docs/quickstart)**
-   **[Alpine.js 3+](https://alpinejs.dev/start-here)**
-   **[Filament 3+](https://filamentphp.com/docs/3.x/panels/installation)**
-   **[Tailwindcss 3+](https://v3.tailwindcss.com/docs/installation)**
-   **[Node.js](https://nodejs.org/docs/latest/api)**
-   **[Heroicons](https://heroicons.com/)**
-   **[Chat.js](https://www.chartjs.org/docs/latest/)**

### Repositório Github

-   **[Curso Laravel](https://github.com/rbdutra/curso-laravel)**

### Exercício prático

-   Criar models em app\Models e migrations em database\migrations: Aluno, Curso, Inscricao [Laravel Models](https://laravel.com/docs/12.x/eloquent)

    > php artisan make:model Aluno -m

        class Aluno extends Model
        {
            protected $table = 'alunos';
            protected $fillable = ['nome', 'endereco'];
            protected $casts = [
                'endereco' => 'array', // Assuming endereco is stored as a JSON array
            ];
            public function inscricoes()
            {
                return $this->hasMany(Inscricao::class, 'aluno_id', 'id');
            }
            public function cursos()
            {
                return $this->belongsToMany(Curso::class, 'inscricao', 'aluno_id', 'curso_id');
            }
        }

    > php artisan make:model Curso -m

        class Curso extends Model
        {
            protected $table = 'cursos';
            protected $fillable = ['nome', 'descricao', 'disponivel'];
            protected $casts = [
                'disponivel' => 'boolean', // Assuming 'disponivel' is a boolean field
            ];
            public function inscricoes()
            {
                return $this->hasMany(Inscricao::class, 'curso_id', 'id');
            }
            public function alunos()
            {
                return $this->belongsToMany(Aluno::class, 'inscricao', 'curso_id', 'aluno_id');
            }
        }

    > php artisan make:model Inscricao -m

        class Inscricao extends Model
        {
            protected $table = 'inscricao';
            protected $fillable = ['aluno_id', 'curso_id', 'data_inscricao', 'matricula', 'situacao_id'];
            public function aluno()
            {
                return $this->belongsTo(Aluno::class, 'aluno_id', 'id');
            }
            public function curso()
            {
                return $this->belongsTo(Curso::class, 'curso_id', 'id');
            }
            public function situacao()
            {
                return $this->belongsTo(Situacao::class, 'situacao_id', 'id');
            }
        }

-   Editar as migrations [Laravel Migrations](https://laravel.com/docs/12.x/migrations)

    > Alunos

        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable(false)->comment('Nome do aluno');
            $table->timestamps();
        });

    > Cursos

        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable(false)->comment('Nome do curso');
            $table->timestamps();
        });

    > Inscrição

        Schema::create('inscricao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aluno_id')->constrained('alunos')->onDelete('cascade')->comment('ID do aluno inscrito');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade')->comment('ID do curso inscrito');
            $table->integer('matricula')->unique()->comment('Matrícula do aluno no curso');
            $table->date('data_inscricao');
            $table->timestamps();
        });

-   Criar tabela situacao: id, descricao, cor (model e migration)

    > php artisan make:model Situacao -m

        class Situacao extends Model
        {
            protected $table = 'situacao';
            protected $fillable = ['descricao', 'cor'];

            public function inscricoes()
            {
                return $this->hasMany(Inscricao::class, 'situacao_id', 'id');
            }
        }

    > migration

          Schema::create('situacao', function (Blueprint $table) {
              $table->id();
              $table->string('descricao')->unique()->comment('Descrição da situação');
              $table->string('cor')->comment('Cor');
              $table->timestamps();
          });

-   Atualizar o model inscricao situacao_id

    > model

        protected $fillable = ['aluno_id', 'curso_id', 'data_inscricao', 'matricula', 'situacao_id'];

-   Atualizar tabela cursos adicionando os campos descrição e disponível

    > php artisan make:migration add_descricao_disponivel_table –-table=curso

    > migration

        public function up(): void
        {
            Schema::table('cursos', function (Blueprint $table) {
                $table->longText('descricao')->comment('Descrição do curso')->nullable(true);
                $table->integer('disponivel')->default(1)->comment('Curso disponível para inscrição');
            });
        }

        public function down(): void
        {
            Schema::table('cursos', function (Blueprint $table) {
                $table->dropColumn('descricao');
                $table->dropColumn('disponivel');
            });
        }

-   Atualizar tabela alunos adicionando o campo endereco

    > php artisan make:migration add_endereco_table –-table=aluno

    > migration

        public function up(): void
        {
            Schema::table('alunos', function (Blueprint $table) {
                $table->longText('endereco')->comment('Endereço do aluno')->nullable(true);
            });
        }

        public function down(): void
        {
            Schema::table('alunos', function (Blueprint $table) {
                $table->dropColumn('endereco');
            });
        }

-   Atualizar tabela inscricao adicionando o campo situação com os dados: **Pré-inscrição, Inscrição e Indeferido**

    > php artisan make:migration add_situacao_table –-table=inscricao

    > migration

        Schema::table('inscricao', function (Blueprint $table) {
            $table->foreignId('situacao_id')
                ->constrained('situacao')
                ->restrictOnUpdate()
                ->restrictOnDelete()
                ->default(1) // Assuming 1 is the default situation ID
                ->nullable()
                ->comment('ID do aluno inscrito');
        });

        public function down(): void
        {
            Schema::table('inscricao', function (Blueprint $table) {
                $table->dropColumn('situacao_id');
            });
        }

-   Executar as migrations (criar as tabelas no banco de dados):

    > php artisan migrate

-   Criar os Resources e adicionar campos no form e columns em tables [Filament Resource](https://filamentphp.com/docs/3.x/panels/resources/getting-started)

    > php artisan make:filament-resource Aluno

    > resource

    ```
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\RichEditor::make('endereco')
                    ->required()
                    ->columnSpanFull(),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('endereco'),
            ])
        ...
    ```

    > php artisan make:filament-resource Curso

    ```
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('descricao')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('disponivel'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('descricao'),
                Tables\Columns\TextColumn::make('disponivel'),
            ])
        ...
    ```

    > php artisan make:filament-resource Inscricao

    ```
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('aluno_id')
                    ->relationship('aluno', 'nome')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\RichEditor::make('endereco')
                            ->required(),
                    ]),

                Forms\Components\Select::make('curso_id')
                    ->relationship('curso', 'nome')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\DatePicker::make('data_inscricao')
                    ->label('Data de Inscrição')
                    ->required(),

                Forms\Components\TextInput::make('matricula')
                    ->label('Matrícula')
                    ->required(),

                Forms\Components\Select::make('situacao_id')
                    ->relationship('situacao', 'descricao')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('descricao')
                            ->required()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('aluno.nome'),
                Tables\Columns\TextColumn::make('curso.nome'),
                Tables\Columns\TextColumn::make('data_inscricao'),
                Tables\Columns\TextColumn::make('matricula'),
                Tables\Columns\TextColumn::make('situacao'),
            ])
        ...
    ```

> php artisan make:filament-resource Situacao

    ```
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('descricao')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\ColorPicker::make('cor')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('descricao'),
                Tables\Columns\ColorColumn::make('cor'),
            ])
        ...
    ```

-   Editar propriedades dos Resources [Heroicons](https://heroicons.com/)

    > resources

    ```
    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Situação';
    protected static ?string $modelLabel = 'Situação ';
    protected static ?string $pluralModelLabel = 'Situações';
    ```

-   Criar o widgets Stats para o dashboard [Filament Widget Stats](https://filamentphp.com/docs/3.x/widgets/stats-overview)

    > php artisan make:filament-widget StatsOverview --stats-overview

    ```
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
    ```

-   Criar o widgets Chats Alunos e Matrícula para o dashboard [Filament Widget Chats](https://filamentphp.com/docs/3.x/widgets/charts)

    > php artisan make:filament-widget DashboardAlunosChart --chart

    ```
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
    ```

    > php artisan make:filament-widget DashboardMatriculasChart --chart

    ```
    protected static ?string $heading = 'Matrículas por mês';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Matriculas por mês',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],
            ],
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        ];
    }
    ```

    > php artisan optimize

-   Alterando o endereço dos AlunoResource.php

    > method

    ```
    use Filament\Forms\Components\Actions\Action;
    use Filament\Forms\Components\Group;
    use Filament\Forms\Components\Section;
    use Filament\Forms\Set;
    use Filament\Notifications\Notification;
    use Illuminate\Support\Facades\Http;


    public static function getFormfieldsCep(string $description)
    {
        return Section::make('Localização')
            ->icon('heroicon-m-map-pin')
            ->description($description)
            ->compact()
            ->schema([

                Group::make()->columns(4)->schema([
                    Forms\Components\TextInput::make('cep')
                        ->mask('99.999-999')
                        ->maxLength(255)
                        ->columnSpan([
                            'sm' => 4,
                            'xl' => 1,
                        ])
                        ->suffixAction(
                            Action::make('buscarCep')
                                ->icon('heroicon-m-magnifying-glass')
                                ->requiresConfirmation(false)
                                ->action(function (Set $set, $state) {
                                    if (blank($state)) {
                                        Notification::make()
                                            ->title('Entre com o CEP')
                                            ->danger()->send();
                                        return;
                                    }
                                    try {
                                        $cep = preg_replace("/[^0-9]/", "", $state);
                                        $cepData =
                                            Http::withOptions([
                                                'verify' => false,
                                            ])
                                                ->get("https://viacep.com.br/ws/{$cep}/json")
                                                ->throw()
                                                ->json();

                                        if ($cepData) {
                                            $set('endereco.logradouro', $cepData['logradouro'] ?? null);
                                            $set('endereco.complemento', $cepData['complemento'] ?? null);
                                            $set('endereco.bairro', $cepData['bairro'] ?? null);
                                            $set('endereco.localidade', $cepData['localidade'] ?? null);
                                            $set('endereco.uf', $cepData['uf'] ?? null);
                                            $set('endereco.estado', $cepData['estado'] ?? null);
                                        } else {
                                            Notification::make()
                                                ->title('CEP não encontrado')
                                                ->danger()
                                                ->send();
                                        }

                                    } catch (Exception $e) {
                                        Notification::make()
                                            ->title('CEP não encontrado')
                                            ->danger()
                                            ->send();
                                    }


                                })
                        ),
                ]),
                Group::make()->columns(5)->schema([
                    Forms\Components\TextInput::make('endereco.logradouro')
                        ->label('Logradouro')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('endereco.complemento')
                        ->label('Complemento')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 1,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('endereco.bairro')
                        ->label('Bairro')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                ]),
                Group::make()->columns(5)->schema([
                    Forms\Components\TextInput::make('endereco.localidade')
                        ->label('Cidade')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('endereco.uf')
                        ->label('UF')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 1,
                        ])
                        ->maxLength(2),
                    Forms\Components\TextInput::make('endereco.estado')
                        ->label('Estado')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                ]),

            ])->columnSpanFull();
    }
    ```

    > form

    ```
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                static::getFormfieldsCep('Preencha o CEP para buscar os dados de endereço automaticamente'),
    ```

    > table

    ```
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('endereco')
                    ->state(function (Aluno $aluno) {
                        $endereco = '';
                        if (is_null($aluno->endereco)) {
                            $endereco = 'Endereço não informado';
                        } else {
                            if (isset($aluno->endereco['logradouro'])) {
                                $endereco .= $aluno->endereco['logradouro'] . ' ';
                            }
                            if (isset($aluno->endereco['complemento'])) {
                                $endereco .= $aluno->endereco['complemento'] . ' ';
                            }
                            if (isset($aluno->endereco['bairro'])) {
                                $endereco .= $aluno->endereco['bairro'] . ' ';
                            }
                            if (isset($aluno->endereco['localidade'])) {
                                $endereco .= $aluno->endereco['localidade'] . ' ';
                            }
                            if (isset($aluno->endereco['uf'])) {
                                $endereco .= $aluno->endereco['uf'] . ' ';
                            }
                            if (isset($aluno->endereco['estado'])) {
                                $endereco .= $aluno->endereco['estado'] . ' ';
                            }
                        }
                        return new HtmlString($endereco);
                    }),
            ])
    ```

-   Criando Filament Custom Page Relatorios [Filament Custom Page](https://filamentphp.com/docs/3.x/panels/pages)

    > php artisan make:filament-page Relatorios

    > app\Filament\Pages\Relatorios.php

    ```
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
                                // ->default(1)
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
                        switch ($this->reportData['relatorio']) {
                            case 1:
                                $aluno_id = 0;
                                if ($this->reportData['aluno_id'])
                                    $aluno_id = $this->reportData['aluno_id'];

                                $link = "/relatorio/alunos/{$aluno_id}";
                                break;
                            case 2:
                                $curso_id = 0;
                                if ($this->reportData['curso_id'])
                                    $curso_id = $this->reportData['curso_id'];

                                $link = "/relatorio/curso/{$curso_id}";
                                break;
                            case 3:
                                $inicio = 0;
                                if ($this->reportData['inicio'])
                                    $inicio = $this->reportData['inicio'];
                                $termino = 0;
                                if ($this->reportData['termino'])
                                    $termino = $this->reportData['termino'];

                                $link = "/relatorio/inscricao/{$inicio}/{$termino}";
                        }
                        return $link;
                    }, true),
            ];
        }
    }
    ```

    > resources\views\filament\pages\relatorios.blade.php [Filament Blade Components](https://filamentphp.com/docs/3.x/support/blade-components/overview)

    ```
    <x-filament-panels::page>

        <x-filament-panels::form wire:submit="enviar">

            {{ $this->reportForm }}

            <x-filament-panels::form.actions :actions="$this->getFormActions()"/>
        </x-filament-panels::form>

    </x-filament-panels::page>
    ```

-   Editando as rotas [Laravel Route](https://laravel.com/docs/12.x/routing)

    > routes\web.php

    ```
    Route::group(['prefix' => 'relatorio'], function () {
        Route::get('/alunos/{aluno_id}', [RelatorioController::class, 'cursosDoAluno'])->name('relatorio.cursosdoaluno');
        Route::get('/curso/{curso_id}', [RelatorioController::class, 'alunosDoCurso'])->name('relatorio.alunosdocurso');
        Route::get('/inscricao/{inicio}/{termino}', [RelatorioController::class, 'inscricaoPeriodo'])->name('relatorio.inscricaoperiodo');
    });
    ```

-   Criando os relatórios

    -   Crie a pasta resources\views\relatorio

    -   Crie o Controller app\Http\Controllers\RelatorioController.php [Laravel Controllers](https://laravel.com/docs/12.x/controllers)

    ```
    namespace App\Http\Controllers;

    use App\Models\Aluno;
    use App\Models\Curso;
    use App\Models\Inscricao;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\View\View;

    class RelatorioController extends Controller
    {
        public function cursosDoAluno($aluno_id): View
        {
            $aluno = Aluno::find($aluno_id);
            $dados = Inscricao::where('aluno_id', '=', $aluno_id)->get();
            return view('relatorio.relatorio-cursosdoaluno', [
                'aluno' => $aluno,
                'dados' => $dados,
            ]);
        }
        public function alunosDoCurso($curso_id): View
        {
            $curso = Curso::find($curso_id);
            $dados = Inscricao::where('curso_id', '=', $curso_id)->get();

            return view('relatorio.relatorio-alunosdocurso', [
                'curso' => $curso,
                'dados' => $dados,
            ]);
        }
        public function inscricaoPeriodo($inicio, $termino): View
        {
            $dados = Inscricao::whereRaw("data_inscricao BETWEEN '{$inicio}' and '{$termino}'")->get();
            $inicio = Carbon::parse($inicio);
            $termino = Carbon::parse($termino);

            return view('relatorio.relatorio-inscricoesrealizadasnoperiodo', [
                'inicio' => $inicio->format('d/m/Y'),
                'termino' => $termino->format('d/m/Y'),
                'dados' => $dados,
            ]);
        }
    }
    ```

    -   Crie o arquivo resources\views\relatorio\report.blade.php [Laravel Blade](https://laravel.com/docs/12.x/blade)

    ```
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>Relatório</title>

            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

            @vite('resources/css/app.css')
        </head>
        <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center flex-col">
            <div class="border-slate-200 rounded-lg my-1 border-2 w-96 p-2">Cabeçalho do Sistema</div>
            <div class="p-2 border-slate-200 rounded-lg my-1 border-2 w-96">
                @yield('content')
            </div>
            <div class="border-slate-200 rounded-lg my-1 border-2 w-96 p-2">Rodapé</div>
        </body>
    </html>
    ```

    -   Crie o arquivo resources\views\relatorio\relatorio-alunosdocurso.blade.php

    ```
    @extends('relatorio.report')

    @section('content')
    <div>
        @if ($dados)
        <h2>Curso: {{ $curso->nome }}</h2>

        <ul>
            @foreach ($dados as $row)
            <li>{{ $row->aluno->nome }}</li>
            @endforeach
        </ul>
        @else
        <h3>Nenhum registro encontrado</h3>
        @endif
    </div>
    @endsection
    ```

    -   Crie o arquivo resources\views\relatorio\relatorio-cursosdoaluno.blade.php

    ```
    @extends('relatorio.report')

    @section('content')
    <div>
        @if ($dados)
        <h2>Aluno: {{ $aluno->nome }}</h2>

        <ul>
            @foreach ($dados as $row)
            <li>{{ $row->curso->nome }}</li>
            @endforeach
        </ul>
        @else
        <h3>Nenhum registro encontrado</h3>
        @endif
    </div>
    @endsection
    ```

    -   Crie o arquivo resources\views\relatorio\relatorio-inscricoesrealizadasnoperiodo.blade.php

    ```
    @extends('relatorio.report')

    @section('content')
    <div>
        <h2>Período: {{ $inicio }} a {{ $termino }}</h2>

        <table>
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Aluno</th>
                    <th>Data Matrícula</th>
                    <th>Matrícula</th>
                </tr>
            </thead>
            @foreach ($dados as $inscricao)
            <tbody>
                <tr>
                    <th>{{ $inscricao->curso->nome }}</th>
                    <th>{{ $inscricao->aluno->nome }}</th>
                    <th>{{ $inscricao->data_inscricao }}</th>
                    <th>{{ $inscricao->matricula }}</th>
                </tr>
            </tbody>
            @endforeach
        </table>
    </div>
    @endsection
    ```
