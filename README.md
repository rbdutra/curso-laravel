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
                                            $set('logradouro', $cepData['logradouro'] ?? null);
                                            $set('complemento', $cepData['complemento'] ?? null);
                                            $set('bairro', $cepData['bairro'] ?? null);
                                            $set('localidade', $cepData['localidade'] ?? null);
                                            $set('uf', $cepData['uf'] ?? null);
                                            $set('estado', $cepData['estado'] ?? null);
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
                    Forms\Components\TextInput::make('logradouro')
                        ->label('Logradouro')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('complemento')
                        ->label('Complemento')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 1,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('bairro')
                        ->label('Bairro')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                ]),
                Group::make()->columns(5)->schema([
                    Forms\Components\TextInput::make('localidade')
                        ->label('Cidade')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 2,
                        ])
                        ->maxLength(255),
                    Forms\Components\TextInput::make('uf')
                        ->label('UF')
                        ->columnSpan([
                            'sm' => 5,
                            'xl' => 1,
                        ])
                        ->maxLength(2),
                    Forms\Components\TextInput::make('estado')
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
