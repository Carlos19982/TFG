<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento_piloto', function (Blueprint $table) {
            $table->id(); // Clave primaria para la tabla pivote
            $table->foreignId('piloto_id')->constrained('pilotos')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('eventos')->onDelete('cascade');
            $table->timestamp('fecha_registro')->nullable(); // Tu campo extra
            $table->timestamps(); // created_at y updated_at (opcional)

            // Opcional: Añadir un índice único para evitar duplicados
            $table->unique(['piloto_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento_piloto');
    }
};