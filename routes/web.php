<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inicio', function (){
    return view('inicio');
});

//Route::get('/notas', [NotaController::class, 'index']);

Route::resource('notas', NotaController::class)->names([
    'index' => 'notas.index',
    'create' => 'notas.create',
    'store' => 'notas.store',
    'show' => 'notas.show',
    'edit' => 'notas.edit',
    'update' => 'notas.update',
    'destroy' => 'notas.destroy'
]);