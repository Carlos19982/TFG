<?php

namespace App\Filament\Resources\GalleryImageResource\Pages;

use App\Filament\Resources\GalleryImageResource;
use App\Models\GalleryImage; // Asegúrate de importar tu modelo
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // Para transacciones (opcional pero recomendado)

class CreateGalleryImage extends CreateRecord
{
    protected static string $resource = GalleryImageResource::class;

    // Almacenará el primer modelo creado para la redirección y notificación
    protected ?Model $firstCreatedModel = null;

    protected function handleRecordCreation(array $data): Model
    {
        // $data['file_path'] viene como un array de rutas de archivos
        // porque el FileUpload en el formulario tiene ->multiple()
        $filePaths = $data['file_path'] ?? [];

        // Otros datos del formulario que se aplicarán a cada imagen
        $eventoId = $data['evento_id'];
        $title = $data['title'] ?? null;
        $caption = $data['caption'] ?? null;
        $baseSortOrder = (int) ($data['sort_order'] ?? 0);

        if (empty($filePaths)) {
            // Esto no debería suceder si el FileUpload es 'required' y minFiles(1)
            // pero es una buena práctica manejarlo.
            // Puedes mostrar una notificación de error o lanzar una excepción.
            // Por ejemplo, usando el sistema de notificaciones de Filament:
            // Notification::make()
            //     ->title('Error al crear imágenes')
            //     ->body('No se seleccionaron archivos de imagen.')
            //     ->danger()
            //     ->send();
            // return new (static::getModel()); // Devuelve una instancia vacía para evitar error fatal

            // O lanzar una excepción si prefieres que la operación falle completamente
            throw new \InvalidArgumentException('No se subieron archivos de imagen. Por favor, selecciona al menos una imagen.');
        }

        // Usar una transacción es buena idea para asegurar que todas las imágenes se creen o ninguna.
        DB::transaction(function () use ($filePaths, $eventoId, $title, $caption, $baseSortOrder) {
            foreach ($filePaths as $index => $individualFilePath) {
                // Por cada ruta de archivo en el array, creamos un nuevo registro GalleryImage
                $imageData = [
                    'evento_id' => $eventoId,
                    'file_path' => $individualFilePath, // Aquí usamos la ruta individual (string)
                    'title' => $title,                 // Título común para este lote
                    'caption' => $caption,             // Descripción común para este lote
                    'sort_order' => $baseSortOrder + $index, // Orden secuencial para el lote
                ];

                $createdModel = static::getModel()::create($imageData);

                // Guardamos una referencia al primer modelo creado para que Filament
                // lo use para la notificación y la redirección (si aplica).
                if ($index === 0) {
                    $this->firstCreatedModel = $createdModel;
                }
            }
        });

        // Devolvemos el primer modelo creado. Si por alguna razón no se creó ninguno
        // (aunque la validación de $filePaths vacío debería prevenirlo),
        // devolvemos una nueva instancia para evitar un error fatal en Filament.
        return $this->firstCreatedModel ?? new (static::getModel());
    }

    /**
     * Opcional: Cambiar la URL de redirección después de crear.
     * Como creamos múltiples registros, es mejor redirigir a la lista.
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

     /**
     * Opcional: Personalizar el título de la notificación de éxito.
     */
    protected function getCreatedNotificationTitle(): ?string
    {
        // Puedes contar cuántas imágenes se crearon si lo deseas
        // $count = count($this->record->file_path ?? []); // $this->record podría no estar completamente populado aquí
        // return $count . ' imágenes de galería creadas exitosamente.';
        return 'Imágenes de galería creadas/añadidas exitosamente.';
    }
}
