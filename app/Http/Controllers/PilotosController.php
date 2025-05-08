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
    public function show(string $id): View
    {
        try {
            $piloto = Pilotos::with(['eventos' => function ($query) {
                    $query->select('eventos.id', 'eventos.nombre'); // Asegúrate de seleccionar al menos estos
                          // ->orderBy('eventos.fecha_inicio', 'desc'); // Puedes quitar la ordenación por fecha si ya no es relevante
                }])
                ->findOrFail($id);
    
            return view('pilotosinformacion', ['piloto' => $piloto]);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("Piloto no encontrado con ID {$id}: " . $e->getMessage());
            abort(404, 'Piloto no encontrado');
        } catch (\Exception $e) {
            Log::error("Error al cargar información del piloto ID {$id}: " . $e->getMessage());
            return view('pilotosinformacion', [
                'error' => 'Ocurrió un error al cargar la información del piloto.'
            ]);
        }
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
