<?php
use App\Http\Controllers\PilotosController; 
use App\Http\Controllers\EventosController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/calendario', [EventosController::class, 'index'])->name('calendario.index');

Route::get('/calendario/informacion', function () {
    return view('informacion');
})->name('calendario.informacion');


Route::get('/pilotos', [PilotosController::class, 'index'])->name('pilotos.index'); {
    return view('pilotos');
};
