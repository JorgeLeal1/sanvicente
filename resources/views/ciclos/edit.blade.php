@extends('layouts.app')
@section('content')
<div class="card shadow col-md-6 mx-auto">
    <div class="card-header bg-warning">Editar Ciclo</div>
    <div class="card-body">
        <form action="{{ route('ciclos.update', $ciclo->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Nombre del Ciclo</label>
                <input type="text" name="nombre" class="form-control" value="{{ $ciclo->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>
@endsection