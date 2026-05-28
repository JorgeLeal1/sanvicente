@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Crear Nuevo Semestre</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('semestres.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Año Académico <span class="text-danger">*</span></label>
                            <select name="anio_academico_id" class="form-select" required>
                                @foreach($anios as $anio)
                                    <option value="{{ $anio->id }}" 
                                        {{ old('anio_academico_id', $anioActual?->id) == $anio->id ? 'selected' : '' }}>
                                        {{ $anio->anio_valor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Clonar estructura del semestre anterior?</label>
                            <select name="clonar_desde" class="form-select">
                                <option value="">-- Crear desde cero --</option>
                                @if($ultimoSemestre)
                                    <option value="{{ $ultimoSemestre->id }}">
                                        Clonar {{ $ultimoSemestre->nombre }} ({{ $ultimoSemestre->anioAcademico?->anio_valor }})
                                    </option>
                                @endif
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Número de Semestre <span class="text-danger">*</span></label>
                                <input type="number" name="numero_semestre" class="form-control" 
                                       min="1" max="4" value="{{ old('numero_semestre') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nombre del Semestre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" class="form-control" 
                                       placeholder="Primer Semestre" value="{{ old('nombre') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio" class="form-control" 
                                       value="{{ old('fecha_inicio') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Fecha de Término <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_termino" class="form-control" 
                                       value="{{ old('fecha_termino') }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Crear Semestre
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection