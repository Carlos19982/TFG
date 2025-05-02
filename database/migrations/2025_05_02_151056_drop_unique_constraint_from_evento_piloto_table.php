<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Ejecuta las migraciones: elimina FKs -> elimina Unique -> re-añade FKs.
     */
    public function up(): void
    {
        Schema::table('evento_piloto', function (Blueprint $table) {
            // 1. Eliminar las claves foráneas existentes
            // Asumiendo los nombres por defecto de Laravel: table_column_foreign
            // ¡¡IMPORTANTE!! Verifica los nombres exactos en tu base de datos o migración original si no son estos.
            $table->dropForeign(['piloto_id']); // O $table->dropForeign('evento_piloto_piloto_id_foreign');
            $table->dropForeign(['evento_id']); // O $table->dropForeign('evento_piloto_evento_id_foreign');

            // 2. Eliminar la restricción/índice único
            $table->dropUnique(['piloto_id', 'evento_id']);
            // O $table->dropUnique('evento_piloto_piloto_id_evento_id_unique');

            // 3. Volver a añadir las claves foráneas (¡recomendado!)
            $table->foreign('piloto_id')->references('id')->on('pilotos')->onDelete('cascade'); // Ajusta onDelete si es necesario
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade'); // Ajusta onDelete si es necesario
        });
    }

    /**
     * Reverse the migrations.
     * Revierte las migraciones: elimina FKs -> re-añade Unique -> re-añade FKs.
     */
    public function down(): void
    {
        Schema::table('evento_piloto', function (Blueprint $table) {
            // 1. Eliminar las claves foráneas (para poder re-añadir el unique)
             $table->dropForeign(['piloto_id']);
             $table->dropForeign(['evento_id']);

            // 2. Volver a añadir la restricción única
            $table->unique(['piloto_id', 'evento_id']);
            // O $table->unique(['piloto_id', 'evento_id'], 'evento_piloto_piloto_id_evento_id_unique');

            // 3. Volver a añadir las claves foráneas
            $table->foreign('piloto_id')->references('id')->on('pilotos')->onDelete('cascade');
            $table->foreign('evento_id')->references('id')->on('eventos')->onDelete('cascade');
        });
    }
};