<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AlunoResource\Pages;
use App\Filament\Resources\AlunoResource\RelationManagers;
use App\Models\Aluno;
use Exception;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

class AlunoResource extends Resource
{
    protected static ?string $model = Aluno::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Alunos';
    protected static ?string $modelLabel = 'Alunos ';
    protected static ?string $pluralModelLabel = 'Alunos';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                static::getFormfieldsCep('Preencha o CEP para buscar os dados de endereço automaticamente'),

                // Forms\Components\RichEditor::make('endereco')
                //     ->required()
                //     ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                // Tables\Columns\TextColumn::make('endereco.logradouro')
                //     ->label('Logradouro')
                //     ->searchable()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('endereco.localidade')
                //     ->label('Cidade')
                //     ->searchable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('endereco')
                    ->html()
                    ->state(function (Aluno $aluno): HtmlString {
                        $endereco = '';
                        if (is_null($aluno->endereco)) {
                            $endereco = 'Endereço não informado';
                        } else {
                            if (isset($aluno->endereco['logradouro'])) {
                                $endereco .= '<span class="text-red-800 border-2 p-2">' . $aluno->endereco['logradouro'] . '</span>';
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

                Tables\Columns\TextColumn::make('inscricoes_count')
                    ->label('Inscrições')
                    ->counts('inscricoes')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAlunos::route('/'),
            'create' => Pages\CreateAluno::route('/create'),
            'edit' => Pages\EditAluno::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
