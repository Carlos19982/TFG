<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class eventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
            DB::table('eventos')->insert([
                'nombre' => 'Evento ' . Str::random(10),
                'imagen' => '', // Campo de imagen vacío (cadena vacía)
                'descripcion' => 'Descripción del evento ' . ($i + 1) . '. ' . Str::random(100),
                'imagen2' => null, // Campo de imagen adicional vacío (null)
                'descripcion2' => 'Descripción adicional del evento ' . ($i + 1) . '. ' . Str::random(50),
                'finalizado' => rand(0, 1), // Booleano aleatorio para finalizado
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}