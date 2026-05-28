@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="card-header bg-warning">Editar Datos del Profesor</div>
    <div class="card-body">
        <form action="{{ route('profesores.update', $profesor->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>RUT</label>
                    <input type="text" name="rut" readonly class="form-control" value="{{ $profesor->rut }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $profesor->nombre }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="{{ $profesor->apellido }}" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label>Especialidad</label>
                    <input type="text" name="especialidad" class="form-control" placeholder="Ej: Matemáticas" value="{{ $profesor->especialidad }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</div>
@endsection