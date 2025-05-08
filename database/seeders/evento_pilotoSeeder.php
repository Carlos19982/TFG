<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class evento_pilotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los IDs de pilotos y eventos existentes
        // Asumimos que los IDs van de 1 a 20 si los seeders anteriores crean 20 registros.
        // En un caso real, podrías querer obtenerlos dinámicamente.
        $pilotoIds = range(1, 20);
        $eventoIds = range(1, 20);

        for ($i = 0; $i < 20; $i++) {
            // Seleccionar un piloto_id y evento_id aleatorio para cada entrada
            // Asegúrate de que estos IDs existan en tus tablas 'pilotos' y 'eventos'
            $pilotoId = $pilotoIds[array_rand($pilotoIds)];
            $eventoId = $eventoIds[array_rand($eventoIds)];

            // Opcional: verificar para evitar duplicados si la combinación debe ser única
            // (aunque tu tabla pivote no tiene una restricción unique en (piloto_id, evento_id) por defecto)

            DB::table('evento_piloto')->insert([
                'piloto_id' => $pilotoId,
                'evento_id' => $eventoId,
                'fecha_registro' => Carbon::now()->subDays(rand(0, 30)), // Fecha de registro aleatoria en los últimos 30 días
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}