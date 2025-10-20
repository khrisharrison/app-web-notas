<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotaController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('notas.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('notas')->name('notas.')->group(function () {
    
    // Ruta para la vista de índice (Web/Blade)
    Route::get('/', [NotaController::class, 'index'])->name('index');
    // Ruta para el formulario de creación (Web/Blade)
    // Deberías añadir aquí las rutas 'create' y 'edit' si tienes formularios Blade.
    // Ejemplo: Route::get('/create', [NoteController::class, 'create'])->name('create');
    // Ejemplo: Route::get('/{nota}/edit', [NoteController::class, 'edit'])->name('edit');

    // Rutas API para la aplicación de notas (JSON)
    // Aunque estas rutas devuelven JSON, las mantenemos en web.php y las protegemos 
    // con 'auth' para un control de sesión simple.

    // GET: Obtener todas las notas del usuario actual
    Route::get('/api/all', [NotaController::class, 'getAll'])->name('api.all');

    // POST: Crear una nueva nota
    Route::post('/api', [NotaController::class, 'store'])->name('api.store');

    // GET: Mostrar una nota específica
    Route::get('/api/{id}', [NotaController::class, 'show'])->name('api.show');

    // PUT/PATCH: Actualizar una nota existente
    Route::put('/api/{nota}', [NotaController::class, 'update'])->name('api.update');
    Route::patch('/api/{nota}', [NotaController::class, 'update']);

    // DELETE: Eliminar una nota
    Route::delete('/api/{nota}', [NotaController::class, 'destroy'])->name('api.destroy');
});


require __DIR__.'/auth.php';
