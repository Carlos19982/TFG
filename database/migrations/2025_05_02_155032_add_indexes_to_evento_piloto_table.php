<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecuta las migraciones (añade los índices).
     */
    public function up(): void
    {
        Schema::table('evento_piloto', function (Blueprint $table) {
            // Añade un índice a la columna piloto_id
            $table->index('piloto_id');

            // Añade un índice a la columna evento_id
            $table->index('evento_id');

            // Añade un índice a la columna fecha_registro (útil para el filtro de fecha)
            $table->index('fecha_registro');
        });
    }

    /**
     * Reverse the migrations.
     * Revierte las migraciones (elimina los índices).
     */
    public function down(): void
    {
        Schema::table('evento_piloto', function (Blueprint $table) {
            // Elimina los índices usando el nombre por defecto (tabla_columna_index)
            // O pasando el array de columnas.
            $table->dropIndex(['piloto_id']); // Nombre por defecto: evento_piloto_piloto_id_index
            $table->dropIndex(['evento_id']); // Nombre por defecto: evento_piloto_evento_id_index
            $table->dropIndex(['fecha_registro']); // Nombre por defecto: evento_piloto_fecha_registro_index
        });
    }
};
