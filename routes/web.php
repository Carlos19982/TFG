<?php
use App\Http\Controllers\PilotosController; 
use App\Http\Controllers\EventosController; 
use App\Http\Controllers\EventopilotoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/calendario', [EventosController::class, 'index'])->name('calendario.index');

Route::get('/calendario/informacion', [EventosController::class, 'show'])->name('calendario.informacion');

Route::get('/pilotos-y-sus-eventos', [EventopilotoController::class, 'index'])->name('pilotos_eventos.index');

Route::get('/pilotos', [PilotosController::class, 'index'])->name('pilotos.index');