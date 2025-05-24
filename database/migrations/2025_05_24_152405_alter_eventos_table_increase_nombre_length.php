<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Cambia la longitud de la columna 'nombre' a 255 (o lo que necesites)
            $table->string('nombre', 255)->change();
        });
    }

    public function down(): void
    {
        Schema::table('eventos', function (Blueprint $table) {
            // Vuelve a la longitud original si haces rollback (¡cuidado si ya hay datos largos!)
            $table->string('nombre', 40)->change();
        });
    }
};