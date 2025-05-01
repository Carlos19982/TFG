<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PilotosResource\Pages;
use App\Filament\Resources\PilotosResource\RelationManagers;
use App\Models\Pilotos;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PilotosResource extends Resource
{
    protected static ?string $model = Pilotos::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nombre')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('Apellidos')
                    ->required()
                    ->maxLength(40),
                Forms\Components\TextInput::make('Descripcion')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('Imagen')
                    ->required()
                    ->maxLength(250),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Apellidos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Descripcion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Imagen')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPilotos::route('/'),
            'create' => Pages\CreatePilotos::route('/create'),
            'edit' => Pages\EditPilotos::route('/{record}/edit'),
        ];
    }
}
