<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SituacaoResource\Pages;
use App\Filament\Resources\SituacaoResource\RelationManagers;
use App\Models\Situacao;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SituacaoResource extends Resource
{
    protected static ?string $model = Situacao::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationLabel = 'Situação';
    protected static ?string $modelLabel = 'Situação ';
    protected static ?string $pluralModelLabel = 'Situações';
    protected static ?string $navigationGroup = 'Cadastro';
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSituacaos::route('/'),
            'create' => Pages\CreateSituacao::route('/create'),
            'edit' => Pages\EditSituacao::route('/{record}/edit'),
        ];
    }
}
