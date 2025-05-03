<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pilotos;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PilotController extends Controller
{
    public function index(): View
    {
        try {
            $pilotos = Pilotos::all();
            return view('pilotos', ['pilotos' => $pilotos]);
        } catch (\Exception $e) {
            Log::error('Error al cargar la vista de pilotos: ' . $e->getMessage());
            return view('pilotos', ['error' => 'No se pudieron cargar los pilotos.', 'pilotos' => collect()]);
            // Alternativa: abort(500, 'Error al cargar los pilotos.');
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
