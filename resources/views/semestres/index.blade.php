@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Semestres Académicos</h1>
        <a href="{{ route('semestres.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Semestre
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Año</th>
                        <th>Semestre</th>
                        <th>Nombre</th>
                        <th>Fechas</th>
                        <th>Ciclos</th>
                        <th>Cursos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semestres as $semestre)
                    <tr>
                        <td>{{ $semestre->anioAcademico->anio_valor ?? 'N/A' }}</td>
                        <td>{{ $semestre->numero_semestre }}</td>
                        <td><strong>{{ $semestre->nombre }}</strong></td>
                        <td>
                            {{ $semestre->fecha_inicio->format('d/m/Y') }} - 
                            {{ $semestre->fecha_termino->format('d/m/Y') }}
                        </td>
                        <td>{{ $semestre->ciclos->count() }}</td>
                        <td>{{ $semestre->cursos->count() }}</td>
                        <td>
                            @if($semestre->estado)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('semestres.show', $semestre) }}" class="btn btn-sm btn-info">
                                Ver
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay semestres registrados</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $semestres->links() }}
        </div>
    </div>
</div>
@endsection