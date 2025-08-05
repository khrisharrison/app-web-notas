<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Nota</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .card { background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 25px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 4px; }
        button { padding: 10px 20px; background: #3490dc; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #2779bd; }
        .back-btn { display: inline-block; margin-top: 20px; color: #4a5568; }
        .error { color: #e53e3e; font-size: 0.875rem; margin-top: 4px; }
        textarea { resize: none; }
    </style>
</head>
<body>
    <h1>Crear Nueva Nota</h1>
    
    <div class="card">
        <form action="{{ route('notas.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="titulo">Titulo:</label>
                <input type="text" name="titulo" id="titulo" required>
                @error('titulo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="contenido">Contenido:</label>
                <textarea type="text" name="contenido" id="contenido" rows="12" cols="102" required></textarea>
                @error('contenido')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit">Guardar</button>
        </form>
    </div>
    
    <a href="{{ route('notas.index') }}" class="back-btn">← Volver a la lista</a>
</body>
</html>