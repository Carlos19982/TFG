<?php
use App\Http\Controllers\PilotosController; 
use App\Http\Controllers\EventosController; 
use App\Http\Controllers\EventopilotoController;
use App\Http\Controllers\GalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/calendario', [EventosController::class, 'index'])->name('calendario.index');

Route::get('/calendario/informacion/{id}', [EventosController::class, 'mostrarDetalleEvento'])
    ->name('calendario.informacion');
    Route::match(['get', 'post'], '/calendario', [EventosController::class, 'index'])->name('calendario.index');

Route::get('/pilotos-y-sus-eventos', [EventopilotoController::class, 'index'])->name('pilotos_eventos.index');

Route::get('/pilotos', [PilotosController::class, 'index'])->name('pilotos.index');
Route::match(['get', 'post'], '/pilotos', [PilotosController::class, 'index'])->name('pilotos.index');

Route::get('/pilotos/{id}', [PilotosController::class, 'show'])->name('pilotos.show');

Route::get('/galeria', [GalleryController::class, 'index'])->name('galeria.index');