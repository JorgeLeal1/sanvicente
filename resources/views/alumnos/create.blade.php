@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Registrar Nuevo Alumno</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('alumnos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">RUT / DNI</label>
                        <input type="text" name="rut" class="form-control" required placeholder="12.345.678-9">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellido" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Edad</label>
                        <input type="number" name="edad" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Curso Asignado</label>
                        <select name="id_curso" class="form-select" required>
                            <option value="">Seleccione un curso...</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}">{{ $curso->nivel }} {{ $curso->letra }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ID Usuario (Opcional)</label>
                        <input type="number" name="id_usuario" class="form-control">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success px-4">Guardar</button>
                    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection