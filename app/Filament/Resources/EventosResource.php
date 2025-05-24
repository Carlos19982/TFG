<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventosResource\Pages;
use App\Filament\Resources\EventosResource\RelationManagers;
use App\Models\Eventos;
use App\Models\BaseEvent; // Importar modelo BaseEvent
use App\Models\Season;   // Importar modelo Season
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select; // Para los nuevos selects
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get; // <--- IMPORTANTE: Para usar en closures de reactividad
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter; // Para los nuevos filtros
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;

class EventosResource extends Resource
{
    protected static ?string $model = Eventos::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $modelLabel = 'Instancia de Evento';
    protected static ?string $pluralModelLabel = 'Instancias de Eventos';
    protected static ?string $navigationLabel = 'Gestionar Instancias de Eventos';
    // protected static ?string $navigationGroup = 'Eventos y Galerías';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Categorización del Evento')
                    ->columns(2)
                    ->schema([
                        Select::make('base_event_id')
                            ->label('Tipo de Evento Base')
                            ->relationship('baseEvent', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live() // <-- AÑADIDO: Hace que este campo sea reactivo
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nombre del Evento Base')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique('base_events', 'name'),
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Crear Nuevo Tipo de Evento Base')
                                    ->modalButton('Crear Evento Base')
                                    ->modalWidth('md');
                            }),

                        Select::make('season_id')
                            ->label('Temporada')
                            ->relationship('season', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            // --- MODIFICACIÓN AQUÍ ---
                            // Deshabilita este campo si 'base_event_id' no está seleccionado
                            ->disabled(fn (Get $get): bool => $get('base_event_id') === null)
                            // Opcional: Ocultar en lugar de deshabilitar
                            // ->hidden(fn (Get $get): bool => $get('base_event_id') === null)
                            ->helperText(fn (Get $get): string => $get('base_event_id') === null ? 'Primero debes seleccionar un Tipo de Evento Base.' : '')
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nombre de la Temporada (ej. 2025 - Edición 1)')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique('seasons', 'name'),
                            ])
                            ->createOptionAction(function (Forms\Components\Actions\Action $action) {
                                return $action
                                    ->modalHeading('Crear Nueva Temporada')
                                    ->modalButton('Crear Temporada')
                                    ->modalWidth('md');
                            }),
                    ]),

                Section::make('Detalles de la Instancia del Evento')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre Descriptivo de la Instancia')
                            ->helperText('Ej: GP España 2025 - Carrera Principal. Se puede generar o personalizar.')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Toggle::make('finalizado')
                            ->label('Evento Finalizado')
                            ->default(false)
                            ->required(),

                        Textarea::make('descripcion')
                            ->label('Descripción Principal (para imagen 4:5)')
                            ->required()
                            ->maxLength(255)
                            ->rows(4)
                            ->columnSpanFull(),

                         Textarea::make('descripcion2')
                            ->label('Descripción Secundaria (para imagen 16:9)')
                            ->maxLength(255)
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Imágenes de la Instancia')
                    ->columns(2)
                    ->schema([
                         FileUpload::make('imagen')
                            ->label('Imagen Principal (4:5)')
                            ->image()
                            ->directory('eventos-imagenes')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['4:5'])
                            ->columnSpan(1),

                         FileUpload::make('imagen2')
                            ->label('Imagen Secundaria (16:9)')
                            ->image()
                            ->directory('eventos-imagenes-secundarias')
                            ->imageEditor()
                            ->imageEditorAspectRatios(['16:9'])
                            ->columnSpan(1),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('imagen2')
                    ->label('Imagen (16:9)')
                    ->disk('public')
                    ->width(120)
                    ->height(null),
                TextColumn::make('nombre')
                    ->label('Nombre Instancia')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('baseEvent.name')
                    ->label('Tipo de Evento')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('season.name')
                    ->label('Temporada')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                IconColumn::make('finalizado')
                    ->label('Finalizado')
                    ->boolean()
                    ->sortable(),
                ImageColumn::make('imagen')->label('Imagen (4:5)')->disk('public')->square()->height(60)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('descripcion')->label('Desc. Principal')->limit(60)->tooltip(fn (Eventos $record): string => $record->descripcion)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('descripcion2')->label('Desc. Secundaria')->limit(60)->tooltip(fn (Eventos $record): string => $record->descripcion2 ?? '')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')->label('Fecha Creación')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Última Actualización')->dateTime('d/m/Y H:i')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('nombre')
                    ->label('Filtrar por Nombre de Instancia')
                    ->form([
                        TextInput::make('nombre_filtro')
                            ->label('Nombre contiene'),
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
                            $indicators['nombre_filtro'] = 'Nombre Instancia contiene "' . $data['nombre_filtro'] . '"';
                        }
                        return $indicators;
                    }),
                SelectFilter::make('base_event_id')
                    ->label('Filtrar por Tipo de Evento')
                    ->relationship('baseEvent', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('season_id')
                    ->label('Filtrar por Temporada')
                    ->relationship('season', 'name')
                    ->searchable()
                    ->preload(),
                 TernaryFilter::make('finalizado')
                    ->label('Estado Finalizado')
                    ->boolean()
                    ->trueLabel('Sí')
                    ->falseLabel('No')
                    ->placeholder('Todos'),
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
            RelationManagers\GalleryImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventos::route('/'),
            'create' => Pages\CreateEventos::route('/create'),
            'edit' => Pages\EditEventos::route('/{record}/edit'),
        ];
    }
}
