<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InscricaoResource\Pages;
use App\Filament\Resources\InscricaoResource\RelationManagers;
use App\Models\Inscricao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InscricaoResource extends Resource
{
    protected static ?string $model = Inscricao::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Inscrições';
    protected static ?string $modelLabel = 'Inscrição ';
    protected static ?string $pluralModelLabel = 'Inscrições';

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
            'index' => Pages\ListInscricaos::route('/'),
            'create' => Pages\CreateInscricao::route('/create'),
            'edit' => Pages\EditInscricao::route('/{record}/edit'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
