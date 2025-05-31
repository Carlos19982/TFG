<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Models\GalleryImage;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification; // Para notificaciones

class CreateGalleryImage extends CreateRecord
{
    protected static string $resource = GalleryImageResource::class;

    protected ?Model $firstCreatedModel = null;

    protected function handleRecordCreation(array $data): Model
    {
        $filePaths = $data['file_path'] ?? [];
        $eventoId = $data['evento_id'];
        $title = $data['title'] ?? null;
        $caption = $data['caption'] ?? null;
        // El orden que el usuario quiere para la PRIMERA imagen del lote
        $requestedSortOrder = (int) ($data['sort_order'] ?? 0);

        if (empty($filePaths)) {
            Notification::make()
                ->title('Error al crear imágenes')
                ->body('No se seleccionaron archivos de imagen.')
                ->danger()
                ->send();
            return new (static::getModel()); // Devuelve instancia vacía para evitar error fatal
        }

        $numberOfFiles = count($filePaths);

        DB::transaction(function () use ($filePaths, $eventoId, $title, $caption, $requestedSortOrder, $numberOfFiles) {
            // 1. HACER HUECO: Incrementar el sort_order de las imágenes existentes
            // para este evento que tengan un sort_order >= al solicitado.
            // El incremento es por la cantidad de nuevas imágenes que se van a insertar.
            GalleryImage::where('evento_id', $eventoId)
                ->where('sort_order', '>=', $requestedSortOrder)
                ->increment('sort_order', $numberOfFiles);

            // 2. Insertar las nuevas imágenes
            foreach ($filePaths as $index => $individualFilePath) {
                // El sort_order para la imagen actual del lote
                $currentSortOrder = $requestedSortOrder + $index;

                $imageData = [
                    'evento_id' => $eventoId,
                    'file_path' => $individualFilePath,
                    'title' => $title,
                    'caption' => $caption,
                    'sort_order' => $currentSortOrder,
                ];

                $createdModel = static::getModel()::create($imageData);

                if ($index === 0) {
                    $this->firstCreatedModel = $createdModel;
                }
            }
        });

        return $this->firstCreatedModel ?? new (static::getModel());
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Imágenes de galería creadas/añadidas exitosamente.';
    }
}
