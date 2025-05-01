<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventoPilotoResource\Pages;
use App\Filament\Resources\EventoPilotoResource\RelationManagers;
use App\Models\EventoPiloto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventoPilotoResource extends Resource
{
    protected static ?string $model = EventoPiloto::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('piloto_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('evento_id')
                    ->required()
                    ->numeric(),
                Forms\Components\DateTimePicker::make('fecha_registro'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('piloto_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('evento_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_registro')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListEventoPilotos::route('/'),
            'create' => Pages\CreateEventoPiloto::route('/create'),
            'edit' => Pages\EditEventoPiloto::route('/{record}/edit'),
        ];
    }
}
