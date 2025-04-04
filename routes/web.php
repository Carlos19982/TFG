<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});

Route::get('/calendario', function () {
    return view('calendario');
});
Route::get('/calendario/informacion', function () {
    return view('informacion');
})->name('calendario.informacion');

Route::get('/pilotos', function () {
    return view('pilotos');
});
