<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            // Se enlaza con tu tabla 'eventos' existente (que representa la instancia del evento)
            $table->foreignId('evento_id')
                  ->constrained('eventos') // El nombre de tu tabla actual de eventos
                  ->onDelete('cascade'); // Si se borra el evento, se borran sus imágenes de galería
            $table->string('file_path'); // Ruta del archivo en el almacenamiento
            $table->string('title')->nullable();
            $table->text('caption')->nullable(); // Pie de foto o descripción
            $table->integer('sort_order')->default(0)->nullable(); // Para ordenar las imágenes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
