<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Añade los campos imagen2, descripcion2 y finalizado a la tabla eventos.
     *
     * @return void
     */
    public function up(): void // Asegúrate de que el tipo de retorno sea ': void' si usas PHP >= 7.1
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Añadimos imagen2, similar a imagen, permitiendo nulos y colocándola después de 'imagen'
            $table->string('imagen2', 50)->nullable()->after('imagen');

            // Añadimos descripcion2, similar a descripcion, permitiendo nulos y después de 'descripcion'
            $table->string('descripcion2', 255)->nullable()->after('descripcion');

            // Añadimos el campo booleano 'finalizado'
            // Lo ponemos como no nulable y con valor por defecto 'false' (0)
            // Esto es importante para las filas existentes, que tomarán este valor por defecto.
            // Lo colocamos después de 'descripcion2'
            $table->boolean('finalizado')->default(false)->after('descripcion2');
        });
    }

    /**
     * Reverse the migrations.
     * Elimina los campos añadidos en el método up().
     *
     * @return void
     */
    public function down(): void // Asegúrate de que el tipo de retorno sea ': void' si usas PHP >= 7.1
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Eliminamos las columnas en el orden inverso o pasándolas como array
            // Es importante que el método down revierta exactamente lo que hizo el up
            $table->dropColumn(['imagen2', 'descripcion2', 'finalizado']);
        });
    }
};