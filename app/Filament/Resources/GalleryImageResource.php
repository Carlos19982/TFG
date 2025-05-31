<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryImageResource\Pages;
use App\Filament\Resources\GalleryImageResource\RelationManagers;
use App\Models\GalleryImage;
use App\Models\Eventos; // Para el Select de Eventos
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Grouping\Group;

class GalleryImageResource extends Resource
{
    protected static ?string $model = GalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo'; // Icono para galería

    // --- Traducciones ---
    protected static ?string $modelLabel = 'Imagen de Galería';
    protected static ?string $pluralModelLabel = 'Imágenes de Galería';
    protected static ?string $navigationLabel = 'Galería de Imágenes';
    // protected static ?string $navigationGroup = 'Contenido Multimedia'; // Opcional

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('evento_id')
                    ->label('Evento Asociado')
                    ->relationship('evento', 'nombre') // Usa la relación 'evento' y muestra el campo 'nombre' del modelo Eventos
                    ->searchable()
                    ->preload()
                    ->required()
                    ->helperText('Selecciona el evento al que pertenecerán estas imágenes.'),

                FileUpload::make('file_path') // Este campo ahora manejará un array de archivos
                    ->label('Archivos de Imagen')
                    ->required()
                    ->multiple() // <-- PERMITE SUBIDA MÚLTIPLE
                    ->minFiles(1) // Opcional: mínimo 1 archivo
                    // ->maxFiles(10) // Opcional: máximo de archivos por subida
                    ->reorderable() // Opcional: permite al usuario reordenar antes de subir
                    ->appendFiles() // Opcional: permite añadir más archivos después de la selección inicial
                    ->image() // Valida que sean imágenes
                    ->directory('gallery_images') // Directorio donde se guardarán en el disco 'public'
                    ->imageEditor() // Opcional: habilita un editor básico (se aplicará a cada imagen si se edita)
                    ->columnSpanFull()
                    ->helperText('Puedes seleccionar varias imágenes a la vez. Los siguientes campos se aplicarán a todas las imágenes subidas en este lote.'),

                TextInput::make('title')
                    ->label('Título para las Imágenes (opcional)')
                    ->maxLength(255)
                    ->helperText('Este título se aplicará a todas las imágenes de este lote.'),

                Textarea::make('caption')
                    ->label('Descripción/Pie de foto para las Imágenes (opcional)')
                    ->rows(3)
                    ->maxLength(1000) // Ajusta según necesidad
                    ->columnSpanFull()
                    ->helperText('Esta descripción se aplicará a todas las imágenes de este lote.'),

                TextInput::make('sort_order')
                    ->label('Orden de Visualización Inicial')
                    ->numeric()->minValue(1)
                    ->default(0)
                    ->helperText('Las imágenes subsiguientes en este lote incrementarán este valor.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // Ordenar por evento y luego por sort_order por defecto
            ->defaultSort('sort_order', 'asc')
            ->reorderable('sort_order')
            ->deferFilters() // Opcional: aplicar filtros solo al hacer clic en botón
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Imagen')
                    ->disk('public') // Especifica el disco de almacenamiento
                    ->square() // O ->circular()
                    ->height(80), // Ajusta el tamaño

                TextColumn::make('evento.nombre') // Accede al nombre a través de la relación 'evento'
                    ->label('Evento Asociado')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn (GalleryImage $record): ?string => $record->title),

                TextColumn::make('caption')
                    ->label('Descripción')
                    ->limit(40)
                    ->tooltip(fn (GalleryImage $record): ?string => $record->caption)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false), // Mostrar por defecto

                TextColumn::make('created_at')
                    ->label('Fecha Subida')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('evento_id')
                    ->label('Filtrar por Evento')
                    ->relationship('evento', 'nombre') // Filtra por la relación 'evento'
                    ->searchable()
                    // ->preload() // Quitado para mejorar rendimiento si hay muchos eventos
                    ,
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])

            ->groups([
                Group::make('evento.nombre') // Agrupa por el nombre del evento relacionado
                    ->label('Evento')        // Etiqueta para la opción de agrupar
                    ->collapsible(),       // Permite que los grupos se puedan colapsar/expandir
            ])
            ->defaultGroup('evento.nombre');
    }

    public static function getRelations(): array
    {
        return [
            // De momento no añadimos RelationManagers aquí
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleryImages::route('/'),
            'create' => Pages\CreateGalleryImage::route('/create'), // Esta página necesita modificación
            'edit' => Pages\EditGalleryImage::route('/{record}/edit'),
        ];
    }
}
