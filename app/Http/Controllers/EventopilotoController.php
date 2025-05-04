<?php

namespace App\Http\Controllers;

use App\Models\Pilotos;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class EventopilotoController extends Controller
{
    /**
     * Muestra vista con pilotos y sus eventos asociados.
     */
    public function index(): View
    {
        try {
            // Obtener pilotos cargando la relación 'eventos' y seleccionando campos
            $pilotosConEventos = Pilotos::with(['eventos' => function ($query) {
                    $query->select('eventos.id', 'eventos.nombre');
                }])
                ->select('pilotos.id', 'pilotos.Nombre', 'pilotos.Apellidos')
                ->get();

            // Devuelve la vista 'pilotos_eventos' pasando los datos
            return view('pilotos_eventos', [
                'pilotosConEventos' => $pilotosConEventos
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cargar vista pilotos_eventos: ' . $e->getMessage());
            // Devuelve vista con mensaje de error
            return view('pilotos_eventos', [
                'error' => 'No se pudieron cargar los datos de pilotos y eventos.'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
