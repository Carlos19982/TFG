<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Importa la fachada Storage

class Eventos extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * Laravel infiere "eventos" de "Evento", pero puedes especificarlo si es diferente.
     * @var string
     */
    // protected $table = 'eventos'; // Descomentar si tu tabla se llama diferente

    /**
     * Indica si el modelo debe tener timestamps (created_at, updated_at).
     * Por defecto es true. Cámbialo a false si tu tabla NO tiene timestamps().
     * @var bool
     */
    // public $timestamps = true;

    /**
     * Los atributos que se pueden asignar masivamente.
     * Es una medida de seguridad para proteger contra asignaciones no deseadas.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
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
        // --- Listener para el evento 'deleting' (Borrar imagen al borrar registro) ---
        static::deleting(function (Eventos $evento) {
            // Verifica si el modelo tiene un valor en el campo 'imagen'
            if ($evento->imagen) {
                // Intenta borrar el archivo del disco de almacenamiento 'public'.
                Storage::disk('public')->delete($evento->imagen);
            }
        });

        // --- Listener para el evento 'updating' (Borrar imagen antigua al actualizar) ---
        static::updating(function (Eventos $evento) {
            // Verifica si el campo 'imagen' ha sido modificado en esta actualización
            if ($evento->isDirty('imagen')) {
                // Obtiene la ruta de la imagen original (antes de la actualización)
                $rutaImagenOriginal = $evento->getOriginal('imagen');

                // Si había una imagen original, intenta borrarla
                if ($rutaImagenOriginal) {
                    Storage::disk('public')->delete($rutaImagenOriginal);
                }
            }
        });
    }

    /**
     * Los pilotos que participan en el evento.
     * (Esta es la relación que definimos en la respuesta anterior)
     */
    public function pilotos()
    {
        return $this->belongsToMany(Pilotos::class, 'evento_piloto')
                    ->using(EventoPiloto::class) // Asumiendo que creaste el modelo pivote EventoPiloto
                    ->withPivot('id', 'fecha_registro')
                    ->withTimestamps();
    }
}