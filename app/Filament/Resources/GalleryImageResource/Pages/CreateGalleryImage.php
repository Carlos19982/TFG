<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Models\GalleryImage;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

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
        $requestedSortOrder = (int) ($data['sort_order'] ?? 0);

        if (empty($filePaths)) {
            Notification::make()
                ->title('Error')
                ->body('No se seleccionaron archivos para subir.')
                ->danger()
                ->send();
            return new (static::getModel());
        }

        $numberOfFiles = count($filePaths);

        DB::transaction(function () use ($filePaths, $eventoId, $title, $caption, $requestedSortOrder, $numberOfFiles) {
            
            // Si sort_order es 0 o no se especificó, usar el siguiente disponible
            if ($requestedSortOrder <= 0) {
                $maxSortOrder = GalleryImage::where('evento_id', $eventoId)->max('sort_order') ?? 0;
                $requestedSortOrder = $maxSortOrder + 1;
            }

            // 1. Hacer espacio para las nuevas imágenes
            // Ordenamos por sort_order DESC para evitar conflictos de clave única
            GalleryImage::where('evento_id', $eventoId)
                ->where('sort_order', '>=', $requestedSortOrder)
                ->orderBy('sort_order', 'desc')
                ->get()
                ->each(function ($image) use ($numberOfFiles) {
                    $image->update(['sort_order' => $image->sort_order + $numberOfFiles]);
                });

            // 2. Insertar las nuevas imágenes
            foreach ($filePaths as $index => $individualFilePath) {
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