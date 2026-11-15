<?php

use App\Http\Controllers\PersonajeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/personajes', [PersonajeController::class, 'index']);
Route::get('/personajes/crear', [PersonajeController::class, 'create']);
Route::post('/personajes', [PersonajeController::class, 'store']);
Route::get('/personajes/{id}/editar', [PersonajeController::class, 'edit']);
Route::put('/personajes/{id}', [PersonajeController::class, 'update']);
Route::delete('/personajes/{id}', [PersonajeController::class, 'destroy']);
Route::post('/personajes/importar', [PersonajeController::class, 'importar']);
