<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage; // Importa la fachada Storage

class Pilotos extends Model
{
    use HasFactory;
    protected $table = 'pilotos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'Nombre',
        'Apellidos',
        'Frase',
        'Descripcion',
        'Imagen'
    ];
        /**
     * The "booted" method of the model.
     * Este método se ejecuta cuando el modelo se inicializa.
     * Aquí podemos registrar los listeners de eventos del modelo.
     *
     * @return void
     */
    protected static function booted(): void
    {
        // --- Listener para el pilotos 'deleting' (Borrar imagen al borrar registro) ---
        static::deleting(function (Pilotos $pilotos) {
            // Verifica si el modelo tiene un valor en el campo 'imagen'
            if ($pilotos->Imagen) {
                // Intenta borrar el archivo del disco de almacenamiento 'public'.
                Storage::disk('public')->delete($pilotos->Imagen);
            }
        });

        // --- Listener para el pilotos 'updating' (Borrar imagen antigua al actualizar) ---
        static::updating(function (Pilotos $pilotos) {
            // Verifica si el campo 'imagen' ha sido modificado en esta actualización
            if ($pilotos->isDirty('Imagen')) {
                // Obtiene la ruta de la imagen original (antes de la actualización)
                $rutaImagenOriginal = $pilotos->getOriginal('Imagen');

                // Si había una imagen original, intenta borrarla
                if ($rutaImagenOriginal) {
                    Storage::disk('public')->delete($rutaImagenOriginal);
                }
            }
        });
    }
    public function eventos(): BelongsToMany // Especifica el tipo de retorno
    {
        return $this->belongsToMany(
                Eventos::class,           // Modelo relacionado
                'evento_piloto',         // Tabla pivote
                'piloto_id',             // Clave foránea de Pilotos en tabla pivote (¡ESTA ES LA CLAVE!)
                'evento_id'              // Clave foránea de Eventos en tabla pivote
            )
            ->using(EventoPiloto::class) // Si usas modelo Pivote personalizado
            ->withPivot('id', 'fecha_registro') // Campos extra de la tabla pivote
            ->withTimestamps(); // Si la tabla pivote tiene timestamps
    }
}
