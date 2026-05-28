@extends('layouts.app')
@section('content')

    @if(Auth::user()->role === 'admin')
    <div class="d-flex justify-content-between mb-3">
        <h3>Gestión de Ciclos</h3>
        <a href="{{ route('ciclos.create') }}" class="btn btn-primary">Nuevo Ciclo</a>
    </div>
    @endif

  

    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Ciclos</h3>

            @if(auth()->user()->role === 'admin')
                <form action="{{ route('ciclos.index') }}" method="GET" class="d-flex">
                    <input type="number" name="buscar_anio" class="form-control form-control-sm me-2" 
                        placeholder="Filtrar por año (ej: 2024)" value="{{ $buscarAnio }}">
                    <button type="submit" class="btn btn-sm btn-primary">Buscar</button>
                    @if($buscarAnio)
                        <a href="{{ route('ciclos.index') }}" class="btn btn-sm btn-secondary ms-1">Limpiar</a>
                    @endif
                </form>
            @else
                <span class="badge bg-info">
                    Periodo: {{ session('periodo_anio_nombre') }} - {{ session('periodo_semestre_nombre') }}
                </span>
            @endif
        </div>
    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>Año</th>
                <th>Semestre</th>
                <th>Ciclo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ciclos as $ciclo)
                <tr>
                    <td>
                        {{ $ciclo->semestre->anioAcademico->anio_valor ?? 'N/A' }}
                    </td>
                    
                    <td>
                        {{ $ciclo->semestre->nombre ?? 'N/A' }}
                    </td>
                    
                    <td>{{ $ciclo->nombre }}</td>
                    
                    <td>
                        <a href="{{ route('ciclos.edit', $ciclo) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('ciclos.destroy', $ciclo) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este ciclo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $ciclos->appends(['buscar_anio' => $buscarAnio])->links() }}
    </div>


@endsection