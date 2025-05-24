<?php

namespace App\Http\Controllers;

// --- Importaciones Necesarias ---
use App\Models\Pilotos;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB; // Para CONCAT en la búsqueda
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException; // Para el catch en show()

class PilotosController extends Controller
{
    /**
     * Muestra la página del equipo de pilotos con funcionalidad de búsqueda.
     * Carga los pilotos con sus eventos asociados.
     * La búsqueda se realiza por Nombre, Apellidos o Nombre y Apellidos combinados.
     */
    public function index(Request $request): View // <-- Este es tu index con la búsqueda
    {
        try {
            $searchTerm = $request->input('termino_busqueda');

            // 1. Iniciar la consulta base para Pilotos
            $query = Pilotos::with(['eventos' => function ($query) {
                    $query->where('eventos.finalizado', false)
                    ->select('eventos.id', 'eventos.nombre'); // Selecciona solo campos necesarios de eventos
                }])
                ->select('pilotos.id', 'pilotos.Nombre', 'pilotos.Apellidos', 'pilotos.Descripcion', 'pilotos.Imagen'); // Campos principales de pilotos

            // 2. Si hay un término de búsqueda, aplicar el filtro
            if ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('pilotos.Nombre', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('pilotos.Apellidos', 'LIKE', "%{$searchTerm}%")
                      // Buscar por Nombre y Apellidos concatenados
                      ->orWhereRaw("CONCAT(pilotos.Nombre, ' ', pilotos.Apellidos) LIKE ?", ["%{$searchTerm}%"]);
                    // Opcional: Si también quieres buscar por Apellidos + Nombre
                    // ->orWhereRaw("CONCAT(pilotos.Apellidos, ' ', pilotos.Nombre) LIKE ?", ["%{$searchTerm}%"]);
                });
            }

            // 3. Paginar los resultados
            $pilotos = $query->paginate(15);

            // 4. Si hay un término de búsqueda, añadirlo a los enlaces de paginación
            if ($searchTerm) {
                $pilotos->appends(['termino_busqueda' => $searchTerm]);
            }

            // Pasar los pilotos y el término de búsqueda a la vista de lista 'pilotos'
            return view('pilotos', [
                'pilotos' => $pilotos,
                'searchTerm' => $searchTerm
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cargar la vista de pilotos: ' . $e->getMessage());
            return view('pilotos', [
                'error' => 'No se pudieron cargar los pilotos.',
                'pilotos' => collect(),
                'searchTerm' => $request->input('termino_busqueda') // Mantener el término en caso de error
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Tu lógica para guardar un nuevo piloto aquí
    }

    /**
     * Display the specified resource (ficha individual del piloto).
     * Este es el método que proporcionaste para mostrar la información de un piloto.
     */
    public function show(string $id): View // <-- Este es tu método show para la ficha individual
    {
        try {
            $piloto = Pilotos::with(['eventos' => function ($query) {
                    // Aquí puedes añadir condiciones a los eventos si es necesario,
                    // por ejemplo, solo los eventos activos o no finalizados:
                    // $query->where('eventos.finalizado', false);
                    $query->where('eventos.finalizado', false)
                    ->select('eventos.id', 'eventos.nombre'); // Asegúrate de seleccionar los campos de eventos
                }])
                // Es buena práctica seleccionar explícitamente los campos del piloto también,
                // aunque findOrFail los traería todos por defecto si no se especifica.
                ->select('pilotos.id', 'pilotos.Nombre', 'pilotos.Apellidos', 'pilotos.Descripcion', 'pilotos.Imagen')
                ->findOrFail($id);
    
            // Devuelve la vista 'pilotosinformacion.blade.php' con el piloto encontrado
            return view('pilotosinformacion', ['piloto' => $piloto]);
    
        } catch (ModelNotFoundException $e) {
            // Si el piloto no se encuentra, lanza un error 404
            Log::error("Piloto no encontrado con ID {$id}: " . $e->getMessage());
            abort(404, 'Piloto no encontrado');
        } catch (\Exception $e) {
            // Para cualquier otro error al cargar la información del piloto
            Log::error("Error al cargar información del piloto ID {$id}: " . $e->getMessage());
            // Puedes optar por mostrar la misma vista con un mensaje de error
            // o redirigir a una página de error general.
            // Asegúrate de que 'pilotosinformacion' pueda manejar un estado de error.
            return view('pilotosinformacion', [
                'error' => 'Ocurrió un error al cargar la información del piloto.',
                'piloto' => null // Para evitar errores en la vista si espera un objeto $piloto
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Tu lógica para actualizar un piloto aquí
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Tu lógica para eliminar un piloto aquí
    }
}