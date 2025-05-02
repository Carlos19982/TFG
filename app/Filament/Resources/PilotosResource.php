<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PilotosResource\Pages;
use App\Filament\Resources\PilotosResource\RelationManagers;
use App\Models\Pilotos;
use Filament\Forms;
use Filament\Forms\Components\Section; // Para organizar el formulario
use Filament\Forms\Components\Textarea; // Para la descripción
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn; // Para las columnas de texto
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PilotosResource extends Resource
{
    protected static ?string $model = Pilotos::class;

    protected static ?string $navigationIcon = 'heroicon-o-user'; // Icono más apropiado

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Personal') // Agrupamos campos
                    ->columns(2) // Distribuir en 2 columnas
                    ->schema([
                        TextInput::make('Nombre')
                            ->required()
                            ->maxLength(40),
                        TextInput::make('Apellidos')
                            ->required()
                            ->maxLength(40),
                        // Usar Textarea para la descripción
                        Textarea::make('Descripcion')
                            ->required()
                            ->maxLength(255)
                            ->rows(4) // Definir altura inicial
                            ->columnSpanFull(), // Ocupar todo el ancho de la sección
                        // Opcional: Campo para foto
                        // Forms\Components\FileUpload::make('foto_url')
                        //     ->label('Foto del Piloto')
                        //     ->image()
                        //     ->directory('pilotos-fotos') // Directorio de almacenamiento
                        //     ->avatar() // Estilo avatar
                        //     ->columnSpanFull(),
                    ]),
                // Puedes añadir más secciones aquí si el modelo crece
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Opcional: Mostrar imagen si la añades al form
                // Tables\Columns\ImageColumn::make('foto_url')
                //     ->label('Foto')
                //     ->circular(), // Mostrar como círculo

                TextColumn::make('Nombre')
                    ->searchable()
                    ->sortable(), // Habilitar ordenación
                TextColumn::make('Apellidos')
                    ->searchable()
                    ->sortable(), // Habilitar ordenación

                TextColumn::make('Descripcion')
                    ->searchable()
                    ->limit(50) // Limitar caracteres mostrados en la tabla
                    ->tooltip(fn (Pilotos $record): string => $record->Descripcion) // Mostrar completo al pasar el ratón
                    // Alternativa: ->wrap() para que el texto continúe abajo
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i') // Formato más legible
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto

                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto
            ])
            ->filters([
                // Aquí podrías añadir filtros si fueran necesarios
                // Por ejemplo, si tuvieras un campo 'activo' (boolean):
                // Tables\Filters\TernaryFilter::make('activo')
            ])
            ->actions([
                // Opcional: Acción para ver detalles
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Añadir acción de borrar
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
            // Aquí podrías añadir Relation Managers si quieres mostrar
            // tablas relacionadas directamente en la página del piloto.
            // Por ejemplo, los eventos en los que ha participado:
            // RelationManagers\EventosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPilotos::route('/'),
            'create' => Pages\CreatePilotos::route('/create'),
            // 'view' => Pages\ViewPiloto::route('/{record}'), // Añadir si usas ViewAction
            'edit' => Pages\EditPilotos::route('/{record}/edit'),
        ];
    }
}
