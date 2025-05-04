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
use Filament\Forms\Components\Toggle;     // Para el campo booleano
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;  // Para mostrar booleanos como iconos
use Filament\Tables\Columns\ImageColumn; // Para mostrar imágenes
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;     // Para filtros personalizados
use Filament\Tables\Filters\TernaryFilter; // Para filtros booleanos
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
                Section::make('Detalles Principales') // Título de la sección
                    ->columns(2) // Dos columnas para distribuir mejor
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del Evento') // Etiqueta
                            ->required()
                            ->maxLength(40)
                            ->columnSpan(1), // Ocupa 1 columna

                        // Campo booleano 'finalizado'
                        Toggle::make('finalizado')
                            ->label('Evento Finalizado') // Etiqueta
                            ->default(false) // Valor por defecto
                            ->required()
                            ->columnSpan(1), // Ocupa 1 columna

                        Textarea::make('descripcion')
                            ->label('Descripción Principal (4:5)') // Etiqueta
                            ->required()
                            ->maxLength(255)
                            ->rows(4)
                            ->columnSpanFull(), // Ocupa todo el ancho

                         Textarea::make('descripcion2') // Nuevo campo descripción 2
                            ->label('Descripción Secundaria (16:9)') // Etiqueta
                            // ->required() // Descomentar si es obligatorio
                            ->maxLength(255)
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Imágenes') // Sección separada para imágenes
                    ->columns(2)
                    ->schema([
                         // Campo para subir la imagen principal (4:5)
                         FileUpload::make('imagen')
                            ->label('Imagen Principal (4:5)') // Etiqueta
                            ->required() // Si la imagen es obligatoria
                            ->image() // Especifica que es una imagen
                            ->directory('eventos-imagenes') // Directorio donde se guardarán
                            ->imageEditor()
                            ->imageEditorAspectRatios(['4:5']) // Sugerir aspect ratio
                            ->columnSpan(1), // Ocupa 1 columna

                         // Campo para subir la imagen secundaria (16:9)
                         FileUpload::make('imagen2')
                            ->label('Imagen Secundaria (16:9)') // Etiqueta
                            // ->required() // Descomentar si es obligatoria
                            ->image()
                            ->directory('eventos-imagenes-secundarias') // Directorio diferente o el mismo?
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9']) // Sugerir aspect ratio
                            ->columnSpan(1), // Ocupa 1 columna
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 // Columna para mostrar la imagen secundaria (16:9)
                 ImageColumn::make('imagen2') // Mostrar imagen2
                    ->label('Imagen (16:9)') // Etiqueta
                    ->disk('public') // Especificar disco
                    ->width(120) // Ajustar ancho (mantendrá proporción si height es null)
                    ->height(null), // Dejar null para que calcule altura según ancho

                TextColumn::make('nombre')
                    ->label('Nombre') // Etiqueta
                    ->searchable()
                    ->sortable(), // Habilitar ordenación

                // Columna para mostrar el estado 'finalizado'
                IconColumn::make('finalizado')
                    ->label('Finalizado') // Etiqueta
                    ->boolean() // Interpretar como booleano (true/false)
                    ->sortable(), // Permite ordenar por este campo

                // Columnas ocultas por defecto (puedes habilitarlas con el selector de columnas)
                ImageColumn::make('imagen') // Imagen original (4:5)
                    ->label('Imagen (4:5)')
                    ->disk('public')
                    ->square()->height(60)
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto

                TextColumn::make('descripcion')
                    ->label('Desc. Principal')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Eventos $record): string => $record->descripcion)
                    ->toggleable(isToggledHiddenByDefault: true), // Oculta por defecto

                TextColumn::make('descripcion2') // Nueva descripción
                    ->label('Desc. Secundaria')
                    ->searchable()
                    ->limit(60)
                    ->tooltip(fn (Eventos $record): string => $record->descripcion2 ?? '') // Usar operador null coalescing
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
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['nombre_filtro'] ?? null) {
                            $indicators['nombre_filtro'] = 'Nombre contiene "' . $data['nombre_filtro'] . '"';
                        }
                        return $indicators;
                    }),

                 // --- Filtro para 'finalizado' ---
                 TernaryFilter::make('finalizado')
                    ->label('Estado Finalizado')
                    ->boolean()
                    ->trueLabel('Sí')
                    ->falseLabel('No')
                    ->placeholder('Todos'), // Opción para no filtrar
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
            'index' => Pages\ListEventos::route('/'),
            'create' => Pages\CreateEventos::route('/create'),
            // 'view' => Pages\ViewEvento::route('/{record}'), // Añadir si creas página View
            'edit' => Pages\EditEventos::route('/{record}/edit'),
        ];
    }
}
