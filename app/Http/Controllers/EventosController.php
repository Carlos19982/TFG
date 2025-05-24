<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // <--- AÑADIR
use App\Models\Eventos;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage; // No lo usa directamente el controlador, pero puede quedarse
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventosController extends Controller
{
    /**
     * Muestra la página del calendario con los eventos (ruta web).
     * Incluye funcionalidad de búsqueda por nombre del evento.
     */
    public function index(Request $request): View // <--- MODIFICADO: Añadir Request
    {
        try {
            $searchTerm = $request->input('termino_busqueda'); // <--- AÑADIR: Obtener término de búsqueda

            // 1. Iniciar la consulta base para Eventos
            $query = Eventos::select('id', 'nombre', 'imagen', 'finalizado') // Seleccionar solo los campos necesarios
                            ->orderBy('finalizado', 'asc');

            // 2. Si hay un término de búsqueda, aplicar el filtro por nombre
            if ($searchTerm) {
                $query->where('nombre', 'LIKE', "%{$searchTerm}%");
            }
            
            // 3. Paginar los resultados
            $eventos = $query->paginate(12);

            // 4. Si hay un término de búsqueda, añadirlo a los enlaces de paginación
            if ($searchTerm) {
                $eventos->appends(['termino_busqueda' => $searchTerm]);
            }
            
            // Pasar la colección de eventos y el término de búsqueda a la vista 'calendario'
            return view('calendario', [
                'eventos' => $eventos,
                'searchTerm' => $searchTerm // <--- AÑADIR: Pasar término a la vista
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cargar el calendario: ' . $e->getMessage());
            return view('calendario', [
                'error' => 'Ocurrió un error al cargar los eventos.',
                'eventos' => collect(), // Devolver colección vacía en error
                'searchTerm' => $request->input('termino_busqueda') // <--- AÑADIR: Pasar término en caso de error
            ]);
        }
    }

    public function mostrarDetalleEvento($id): View
    {
        try {
            $evento = Eventos::with('pilotos')->findOrFail($id); // Asumiendo que pilotos es la relación que necesitas

            return view('informacion', ['evento' => $evento]);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Evento no encontrado');

        } catch (\Exception $e) {
            Log::error("Error al cargar detalle evento ID {$id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            // Considera pasar null para $evento si la vista 'informacion' lo espera
            return view('informacion', [
                'error' => 'No se pudo cargar la información del evento. Por favor, inténtalo más tarde.',
                'evento' => null
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
        // Este método no parece estar siendo utilizado por tus rutas web públicas.
        // El detalle del evento lo maneja mostrarDetalleEvento.
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