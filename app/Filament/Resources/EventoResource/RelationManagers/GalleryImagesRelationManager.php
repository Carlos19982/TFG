<?php

namespace App\Filament\Resources\EventosResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model; // Para el handleRecordCreation
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB; // Para transacciones

class GalleryImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'galleryImages';

    protected static ?string $recordTitleAttribute = 'file_path'; // O 'title' si siempre lo tienes

    // --- Traducciones ---
    protected static ?string $modelLabel = 'Imagen de Galería';
    protected static ?string $pluralModelLabel = 'Imágenes de Galería';
    protected static ?string $title = 'Galería de Imágenes del Evento';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file_path') // Este campo ahora manejará un array de archivos
                    ->label('Archivos de Imagen')
                    ->required()
                    ->multiple() // PERMITE SUBIDA MÚLTIPLE
                    ->minFiles(1)
                    ->reorderable()
                    ->appendFiles()
                    ->image()
                    ->directory('gallery_images') // Directorio donde se guardarán
                    ->imageEditor()
                    ->columnSpanFull()
                    ->helperText('Puedes seleccionar varias imágenes a la vez. Los siguientes campos se aplicarán a todas.'),

                TextInput::make('title')
                    ->label('Título Común para las Imágenes (opcional)')
                    ->maxLength(255),

                Textarea::make('caption')
                    ->label('Descripción/Pie de foto Común (opcional)')
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull(),

                TextInput::make('sort_order')
                    ->label('Orden de Visualización Inicial')
                    ->numeric()
                    ->default(0)
                    ->helperText('Las imágenes subsiguientes en este lote incrementarán este valor.'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('file_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->square()
                    ->height(60),

                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn (?Model $record): ?string => $record->title ?? null),


                TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Subida el')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                // No suelen ser necesarios muchos filtros aquí
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    // Sobrescribimos el proceso de creación para manejar múltiples archivos
                    ->using(function (array $data, RelationManager $livewire): Model {
                        $filePaths = $data['file_path'] ?? [];
                        $ownerRecord = $livewire->getOwnerRecord(); // Obtiene el Evento (instancia) actual
                        $title = $data['title'] ?? null;
                        $caption = $data['caption'] ?? null;
                        $baseSortOrder = (int) ($data['sort_order'] ?? 0);
                        $firstCreatedModel = null;

                        if (empty($filePaths)) {
                            throw new \Exception('No se subieron archivos de imagen.');
                        }

                        DB::transaction(function () use ($filePaths, $ownerRecord, $title, $caption, $baseSortOrder, &$firstCreatedModel) {
                            foreach ($filePaths as $index => $filePath) {
                                $imageData = [
                                    // 'evento_id' se establece automáticamente por la relación
                                    'file_path' => $filePath,
                                    'title' => $title,
                                    'caption' => $caption,
                                    'sort_order' => $baseSortOrder + $index,
                                ];
                                $createdModel = $ownerRecord->galleryImages()->create($imageData);
                                if ($index === 0) {
                                    $firstCreatedModel = $createdModel;
                                }
                            }
                        });
                        return $firstCreatedModel ?? new ($livewire->getRelatedModel());
                    })
                    ->label('Añadir Nuevas Imágenes'),
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
            ->reorderable('sort_order'); // Habilita reordenar arrastrando si tienes 'sort_order'
    }
}
