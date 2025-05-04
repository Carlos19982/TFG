<?php

namespace App\Http\Controllers;

// --- Importaciones Necesarias ---
use App\Models\Pilotos;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
// Ya no necesitamos 'Storage' aquí si solo lo usa la vista
// use Illuminate\Support\Facades\Storage;

class PilotosController extends Controller
{
    /**
     * Muestra la página del equipo de pilotos.
     * Carga los pilotos con sus eventos asociados.
     */
    public function index(): View
    {
        try {
            // 1. Obtener pilotos CON sus eventos (Eager Loading)
            $pilotos = Pilotos::with(['eventos' => function ($query) {
                    $query->select('eventos.id', 'eventos.nombre');
                }])
                ->select('pilotos.id', 'pilotos.Nombre', 'pilotos.Apellidos', 'pilotos.Descripcion', 'pilotos.Imagen')
                ->get();

            return view('pilotos', ['pilotos' => $pilotos]);

        } catch (\Exception $e) {
            Log::error('Error al cargar la vista de pilotos: ' . $e->getMessage());
            return view('pilotos', [
                'error' => 'No se pudieron cargar los pilotos.',
                'pilotos' => collect()
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
