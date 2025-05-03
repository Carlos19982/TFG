<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ThemeSettingsController;
use App\Http\Controllers\Api\PilotController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/theme-settings', [ThemeSettingsController::class, 'updateSettings']);
Route::get('/pilots', [PilotController::class, 'index']);