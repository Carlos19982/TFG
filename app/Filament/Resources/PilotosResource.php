<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PilotosResource\Pages;
use App\Filament\Resources\PilotosResource\RelationManagers;
use App\Models\Pilotos;
use Filament\Forms;
use Filament\Forms\Components\FileUpload; // Asegúrate de importar
use Filament\Forms\Components\Section; // Para organizar el formulario
use Filament\Forms\Components\Textarea; // Para la descripción
use Filament\Forms\Components\TextInput; // Para campos de texto en filtros
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn; // Para mostrar imágenes
use Filament\Tables\Columns\TextColumn; // Para las columnas de texto
use Filament\Tables\Filters\Filter; // Para filtros personalizados
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr; // Para el indicador del filtro


class PilotosResource extends Resource
{
    protected static ?string $model = Pilotos::class;

    protected static ?string $navigationIcon = 'heroicon-o-user'; // Icono

    // --- Traducciones para el Modelo y Navegación ---
    protected static ?string $modelLabel = 'Piloto'; // Nombre singular del modelo
    protected static ?string $pluralModelLabel = 'Pilotos'; // Nombre plural del modelo
    protected static ?string $navigationLabel = 'Gestionar Pilotos'; // Texto en la barra lateral
    // protected static ?string $navigationGroup = 'Administración'; // Opcional: Grupo en la barra lateral

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información Personal') // Título de la sección
                    ->columns(2)
                    ->schema([
                        TextInput::make('Nombre')
                            ->label('Nombre') // Etiqueta del campo
                            ->required()
                            ->maxLength(40),
                        TextInput::make('Apellidos')
                            ->label('Apellidos') // Etiqueta del campo
                            ->required()
                            ->maxLength(40),
                        Textarea::make('Descripcion')
                            ->label('Descripción') // Etiqueta del campo
                            ->required()
                            ->maxLength(255)
                            ->rows(4)
                            ->columnSpanFull(),
                        FileUpload::make('Imagen') // Usar 'I' mayúscula
                            ->label('Foto del Piloto')
                            ->image()
                            ->directory('pilotos-fotos') // Directorio de almacenamiento
                            ->imageEditor() // Opcional
                            ->avatar() // Opcional
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Opcional: Mostrar imagen si la añades al form
                // Tables\Columns\ImageColumn::make('foto_url')
                //     ->label('Foto') // Etiqueta de columna
                //     ->circular(),

                TextColumn::make('Nombre')
                    ->label('Nombre') // Etiqueta de columna
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Apellidos')
                    ->label('Apellidos') // Etiqueta de columna
                    ->searchable()
                    ->sortable(),
                    
                ImageColumn::make('Imagen')
                    ->label('Imagen') // Etiqueta
                    ->disk('public') // Especifica el disco donde buscar
                    ->circular()
                    ->height(60), // Ajusta el tamaño según necesites

                TextColumn::make('Descripcion')
                    ->label('Descripción') // Etiqueta de columna
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn(Pilotos $record): string => $record->Descripcion)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Fecha Creación') // Etiqueta de columna
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Última Actualización') // Etiqueta de columna
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Columna para mostrar la imagen
            ])
            ->filters([
                // --- Filtro por Nombre y Apellidos ---
                Filter::make('nombre_apellidos')
                    ->label('Filtrar por Nombre/Apellidos') // Etiqueta del filtro
                    ->form([
                        TextInput::make('nombre_filtro')
                            ->label('Nombre contiene'), // Etiqueta del campo de filtro
                        TextInput::make('apellidos_filtro')
                            ->label('Apellidos contiene'), // Etiqueta del campo de filtro
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            // Aplica filtro por nombre si se introdujo texto
                            ->when(
                                $data['nombre_filtro'],
                                fn(Builder $query, $nombre): Builder => $query->where('Nombre', 'like', "%{$nombre}%")
                            )
                            // Aplica filtro por apellidos si se introdujo texto
                            ->when(
                                $data['apellidos_filtro'],
                                fn(Builder $query, $apellidos): Builder => $query->where('Apellidos', 'like', "%{$apellidos}%")
                            );
                    })
                    // Muestra qué filtros están activos
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['nombre_filtro'] ?? null) {
                            $indicators['nombre_filtro'] = 'Nombre contiene "' . $data['nombre_filtro'] . '"';
                        }
                        if ($data['apellidos_filtro'] ?? null) {
                            $indicators['apellidos_filtro'] = 'Apellidos contienen "' . $data['apellidos_filtro'] . '"';
                        }
                        return $indicators;
                    }),

                // Otros filtros que puedas necesitar...
            ])
            ->actions([
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
            // RelationManagers...
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
