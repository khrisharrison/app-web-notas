<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;

Route::get('/', function () {
    return view('prueba');
});

Route::get('/inicio', function (){
    return view('inicio');
});

//Route::get('/prueba', function (){
//    return view('prueba');
//});

//Route::get('/notas', [NotaController::class, 'index']);

Route::resource('notas', NotaController::class)->names([
    'index' => 'notas.index',
    'store' => 'notas.store',
    'show' => 'notas.show',
    'update' => 'notas.update',
    'destroy' => 'notas.destroy'
]);
/*
// Obtener todas las notas
Route::get('/notas', [NoteController::class, 'index'])->name('notas.index');

// Obtener una nota específica
Route::get('/notas/{id}', [NoteController::class, 'show'])->name('notas.show');

// Crear nueva nota
Route::post('/notas', [NoteController::class, 'store'])->name('notas.store');

// Actualizar nota existente
Route::put('/notas/{nota}', [NoteController::class, 'update'])->name('notas.update');

// Eliminar nota
Route::delete('/notas/{nota}', [NoteController::class, 'destroy'])->name('notas.destroy');*/