@extends('notas.index')

@section('content')
<div class="card">
    <div class="detail-item">
        <span class="detail-label">Nombre:</span>
        <span>{{ $nota->titulo }}</span>
    </div>
    
    <div class="detail-item">
        <span class="detail-label">Precio:</span>
        <span>${{ $nota->contenido }}</span>
    </div>
    
    <div class="detail-item">
        <span class="detail-label">Creado:</span>
        <span>{{ $nota->created_at->format('d/m/Y H:i') }}</span>
    </div>
    
    <div class="detail-item">
        <span class="detail-label">Actualizado:</span>
        <span>{{ $nota->updated_at->format('d/m/Y H:i') }}</span>
    </div>
    
    <div class="btn-group">
        <a href="{{ route('notas.edit', $nota->id) }}" class="btn btn-primary">Editar</a>
        <form action="{{ route('notas.destroy', $nota->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
        </form>
    </div>
</div>
@endsection