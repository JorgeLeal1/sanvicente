@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Semestre: {{ $semestre->nombre }}</h2>
    <p><strong>Año Académico:</strong> {{ $semestre->anioAcademico->anio_valor ?? 'N/A' }}</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Ciclos</h5>
                    <h3 class="text-primary">{{ $semestre->ciclos->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Cursos</h5>
                    <h3 class="text-primary">{{ $semestre->cursos->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5>Alumnos Matriculados</h5>
                    <h3 class="text-primary">{{ $semestre->matriculas->count() ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Ciclos y Cursos -->
    <h4 class="mt-5">Detalle de Ciclos y Cursos</h4>
    @foreach($semestre->ciclos as $ciclo)
        <div class="card mb-3">
            <div class="card-header bg-light">
                <strong>{{ $ciclo->nombre }}</strong>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($ciclo->cursos as $curso)
                        <li class="list-group-item">
                            <strong>{{ $curso->nivel }} {{ $curso->letra }}</strong>
                            @if($curso->profesorJefe)
                                <span class="badge bg-info ms-2">
                                    Jefe: {{ $curso->profesorJefe->persona->fullName() ?? 'Sin asignar' }}
                                </span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach
</div>
@endsection