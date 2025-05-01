<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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