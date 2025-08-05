<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index(){
        $notas = Nota::all();
        return view('notas.index', compact('notas'));
    }

    // Mostrar formulario creación
    public function create()
    {
        $notas = Nota::all();
        return view('notas.create', compact('notas'));
    }

    // Crear nuevo registro (POST)
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'nullable|string'
        ]);

        $notas = Nota::create($request->all());

        return response()->json($notas, 201);
    }

    // Obtener un registro específico (GET)
    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        return response()->json($nota);
    }

    // Mostrar formulario edición
    public function edit($id)
    {
        $notas = Producto::findOrFail($id);
        return view('notas.edit', compact('notas'));
    }

    // Actualizar un registro (PUT/PATCH)
    public function update(Request $request, $id)
    {
        $notas = Nota::findOrFail($id);
        
        $validated = $request->validate([
            'titulo' => 'sometimes|string',
            'contenido' => 'sometimes|string'
        ]);

        $notas->update($validated);
        return $notas;
    }

    // Eliminar un registro (DELETE)
    public function destroy($id)
    {
        $notas = Nota::findOrFail($id);
        $notas->delete();
        return response()->json(null, 204); // Respuesta vacía con código 204
    }
}
