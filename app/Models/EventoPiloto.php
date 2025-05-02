<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EventoPiloto extends Pivot
{
    // Especifica el nombre de la tabla si no sigue la convención
    protected $table = 'evento_piloto';

    // Indica que la clave primaria 'id' es auto-incremental
    // Laravel por defecto asume que las tablas pivote NO tienen ID auto-incremental
    public $incrementing = true;

    // Si quieres usar asignación masiva (Mass Assignment)
    protected $fillable = [
        'piloto_id',
        'evento_id',
        'fecha_registro',
    ];

    // Define las conversiones de tipos si es necesario (e.g., para fechas)
    protected $casts = [
        'fecha_registro' => 'datetime',
    ];

     public function piloto()
     {
         return $this->belongsTo(Pilotos::class);
     }

     public function evento()
     {
         return $this->belongsTo(Eventos::class);
     }
}