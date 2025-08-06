<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    public function index()
    {
        $notas = Nota::orderBy('updated_at', 'desc')->get();
        return response()->json($notas);
    }

    // Obtener un registro específico (GET)
    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        return response()->json($nota);
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

    // Actualizar un registro (PUT/PATCH)
    public function update(Request $request, Nota $nota)
    {   
        $request->validate([
            'titulo' => 'required|string',
            'contenido' => 'nullable|string'
        ]);

        $nota->update($request->all());
        return response()->json($nota);
    }

    // Eliminar un registro (DELETE)
    public function destroy(Nota $nota)
    {
        $nota->delete();
        return response()->json(null, 204); // Respuesta vacía con código 204
    }
}
