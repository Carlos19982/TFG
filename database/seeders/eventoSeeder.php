<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventoSeeder extends Seeder // Nombre de clase como lo tienes: eventoSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener IDs disponibles de base_events y seasons
        // Asegúrate que BaseEventSeeder y SeasonSeeder se ejecuten ANTES que este.
        $baseEventIds = DB::table('base_events')->pluck('id')->toArray();
        $seasonIds = DB::table('seasons')->pluck('id')->toArray();

        if (empty($baseEventIds) || empty($seasonIds)) {
            $this->command->warn('Por favor, ejecuta BaseEventSeeder y SeasonSeeder primero, o asegúrate de que tengan datos.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            $selectedBaseEventId = $baseEventIds[array_rand($baseEventIds)];
            $selectedSeasonId = $seasonIds[array_rand($seasonIds)];

            // Opcional: generar un nombre de instancia más descriptivo
            $baseEventName = DB::table('base_events')->where('id', $selectedBaseEventId)->value('name');
            $seasonName = DB::table('seasons')->where('id', $selectedSeasonId)->value('name');
            $instanceName = $baseEventName . ' - ' . $seasonName . ' #' . ($i + 1);

            DB::table('eventos')->insert([
                'base_event_id' => $selectedBaseEventId, // Nuevo
                'season_id' => $selectedSeasonId,       // Nuevo
                'nombre' => $instanceName, // Nombre de la instancia del evento
                'imagen' => 'eventos-imagenes/placeholder_4_5.png', // Ruta placeholder
                'descripcion' => 'Descripción de la instancia del evento ' . ($i + 1) . '. ' . Str::random(100),
                'imagen2' => 'eventos-imagenes-secundarias/placeholder_16_9.png', // Ruta placeholder
                'descripcion2' => 'Descripción adicional de la instancia ' . ($i + 1) . '. ' . Str::random(50),
                'finalizado' => rand(0, 1),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
