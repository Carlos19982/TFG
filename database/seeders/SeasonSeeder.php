<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seasonNames = [
            'Temporada 2024 - Edición 1',
            'Temporada 2024 - Edición 2',
            'Temporada 2025 - Apertura',
            'Temporada 2025 - Clausura',
            'Edición Especial 2026'
        ];

        foreach ($seasonNames as $name) {
            $year = null;
            if (preg_match('/(\d{4})/', $name, $matches)) {
                $year = (int)$matches[1];
            }

            DB::table('seasons')->insert([
                'name' => $name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
