<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotaController extends Controller
{
    /**
     * Aplica el middleware 'auth' a todas las acciones del controlador.
     */
    public function __construct()
    {
        // Un usuario debe estar logueado para acceder a cualquier método aquí.
        $this->middleware('auth'); 
    }

    public function index()
    {
        $notas = Nota::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        return view('notas.index', compact('notas'));
    }
    
    public function getAll()
    {
        $notas = Nota::where('user_id', auth()->id())->orderBy('updated_at', 'desc')->get();
        return response()->json($notas);
    }

    // Obtener un registro específico (GET)
    public function show($id)
    {
        $nota = Nota::findOrFail($id);
        if ($nota->user_id !== auth()->id()) {
            // Un usuario no puede ver la nota de otro
            abort(403, 'No tienes permiso para ver esta nota.');
        }
        return response()->json($nota);
    }

    // Crear nuevo registro (POST)
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string'
        ]);

        $notas = Nota::create([
            'user_id' => auth()->id(),
            'titulo' => $request->titulo, // Asumiendo que 'title' en la DB es el campo
            'contenido' => $request->contenido, // Asumiendo que 'content' en la DB es el campo
        ]);

        return response()->json($notas, Response::HTTP_CREATED);
    }

    // Actualizar un registro (PUT/PATCH)
    public function update(Request $request, Nota $nota)
    {   
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para actualizar esta nota.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string'
        ]);

        $nota->update($request->all());
        return response()->json($nota);
    }

    // Eliminar un registro (DELETE)
    public function destroy(Nota $nota)
    {
        if ($nota->user_id !== auth()->id()) {
            abort(403, 'No tienes permiso para eliminar esta nota.');
        }

        $nota->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT); // Respuesta vacía con código 204
    }
}