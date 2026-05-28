@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Editar Alumno: {{ $alumno->nombre }} {{ $alumno->apellido }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RUT</label>
                        <input type="text" name="rut" class="form-control" value="{{ $alumno->rut }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombre" class="form-control" value="{{ $alumno->nombre }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellido" class="form-control" value="{{ $alumno->apellido }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Edad</label>
                        <input type="number" name="edad" class="form-control" value="{{ $alumno->edad }}" required>
                    </div>  
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ $alumno->fecha_nacimiento }}" required>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Cambiar de Curso</label>
                        <select name="id_curso" class="form-select" required>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ $alumno->id_curso == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->nivel }} {{ $curso->letra }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection