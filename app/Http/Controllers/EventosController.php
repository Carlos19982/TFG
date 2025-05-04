<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventos;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EventosController extends Controller
{
    /**
     * Muestra la página del calendario con los eventos (ruta web).
     */
    public function index(): View
    {
        try {
            // Obtener eventos (seleccionando campos necesarios)
            $eventos = Eventos::all();

            // Pasar la colección de eventos a la vista 'calendario'
            return view('calendario', ['eventos' => $eventos]);
        } catch (\Exception $e) {
            Log::error('Error al cargar el calendario: ' . $e->getMessage());
            return view('calendario', ['error' => 'Ocurrió un error al cargar los eventos.']);
        }
    }

    public function mostrarDetalleEvento($id): View
    {
        try {
            $evento = Eventos::with('pilotos')->findOrFail($id);

            return view('informacion', ['evento' => $evento]);

        } catch (ModelNotFoundException $e) {
            abort(404, 'Evento no encontrado');

        } catch (\Exception $e) {
            Log::error("Error al cargar detalle evento ID {$id}: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            return view('informacion', ['error' => 'No se pudo cargar la información del evento. Por favor, inténtalo más tarde.']);
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
        try {
            $evento = Eventos::findOrFail($id);
            return view('calendario.informacion', ['evento' => $evento]);

        } catch (\Exception $e) {
            Log::error('Error al cargar la información del evento: ' . $e->getMessage());
            return view('calendario.informacion', ['error' => 'Ocurrió un error al cargar la información del evento.']);
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
