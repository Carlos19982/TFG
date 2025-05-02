<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventosResource\Pages;
use App\Filament\Resources\EventosResource\RelationManagers;
use App\Models\Eventos;
use Filament\Forms;
use Filament\Forms\Components\FileUpload; // Para subir imágenes
use Filament\Forms\Components\Section;    // Para organizar el formulario
use Filament\Forms\Components\Textarea;   // Para la descripción
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn; // Para mostrar imágenes
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;     // Para filtros personalizados
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;             // Para el indicador del filtro

class EventosResource extends Resource
{
    protected static ?string $model = Eventos::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days'; // Icono más apropiado

    // --- Traducciones para el Modelo y Navegación ---
    protected static ?string $modelLabel = 'Evento'; // Nombre singular del modelo
    protected static ?string $pluralModelLabel = 'Eventos'; // Nombre plural del modelo
    protected static ?string $navigationLabel = 'Gestionar Eventos'; // Texto en la barra lateral
    // protected static ?string $navigationGroup = 'Administración'; // Opcional: Grupo en la barra lateral

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detalles del Evento') // Título de la sección
                    ->columns(1) // Una columna por defecto para este layout
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del Evento') // Etiqueta
                            ->required()
                            ->maxLength(40),

                        // Campo para subir la imagen
                        FileUpload::make('imagen')
                            ->label('Imagen del Evento') // Etiqueta
                            ->required() // Si la imagen es obligatoria
                            ->image() // Especifica que es una imagen
                            ->directory('eventos-imagenes') // Directorio donde se guardarán
                            ->imageEditor() // Opcional: Habilita editor básico
                            ->columnSpanFull(), // Ocupar todo el ancho

                        Textarea::make('descripcion')
                            ->label('Descripción') // Etiqueta
                            ->required()
                            ->maxLength(255)
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna para mostrar la imagen
                ImageColumn::make('imagen')
                    ->label('Imagen') // Etiqueta
                    ->square() // O ->circular()
                    ->height(60), // Ajusta el tamaño según necesites

                TextColumn::make('nombre')
                    ->label('Nombre') // Etiqueta
                    ->searchable()
                    ->sortable(), // Habilitar ordenación

                TextColumn::make('descripcion')
                    ->label('Descripción') // Etiqueta
                    ->searchable()
                    ->limit(60) // Limitar caracteres
                    ->tooltip(fn (Eventos $record): string => $record->descripcion) // Mostrar completo al pasar ratón
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto

                TextColumn::make('created_at')
                    ->label('Fecha Creación') // Etiqueta
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Última Actualización') // Etiqueta
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // --- Filtro por Nombre ---
                Filter::make('nombre')
                    ->label('Filtrar por Nombre') // Etiqueta del filtro
                    ->form([
                        TextInput::make('nombre_filtro')
                            ->label('Nombre contiene'), // Etiqueta del campo de filtro
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['nombre_filtro'],
                                fn (Builder $query, $nombre): Builder => $query->where('nombre', 'like', "%{$nombre}%")
                            );
                    })
                    // Muestra qué filtro está activo
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['nombre_filtro'] ?? null) {
                            $indicators['nombre_filtro'] = 'Nombre contiene "' . $data['nombre_filtro'] . '"';
                        }
                        return $indicators;
                    }),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()->label('Ver'), // Si tienes página View
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
            // Aquí podrías añadir Relation Managers, por ejemplo, para ver los pilotos inscritos:
            // RelationManagers\PilotosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventos::route('/'),
            'create' => Pages\CreateEventos::route('/create'),
            // 'view' => Pages\ViewEvento::route('/{record}'), // Añadir si creas página View
            'edit' => Pages\EditEventos::route('/{record}/edit'),
        ];
    }
}
