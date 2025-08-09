<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;

Route::get('/', [NotaController::class, 'index'])->name('notas.index');

// API para operaciones CRUD
Route::prefix('api')->group(function () {
    // Obtener todas las notas
    Route::get('/notas', [NotaController::class, 'getAll']);
    
    // Obtener una nota específica
    Route::get('/notas/{id}', [NotaController::class, 'show']);
    
    // Crear nueva nota
    Route::post('/notas', [NotaController::class, 'store']);
    
    // Actualizar nota existente
    Route::put('/notas/{nota}', [NotaController::class, 'update']);
    
    // Eliminar nota
    Route::delete('/notas/{nota}', [NotaController::class, 'destroy']);
});

Route::get('/inicio', function (){
    return view('inicio');
});