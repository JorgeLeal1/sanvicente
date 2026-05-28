@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning">
            <h4 class="mb-0">Editar Curso: {{ $curso->nivel }} {{ $curso->letra }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos.update', $curso->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nivel</label>
                        <input type="text" name="nivel" class="form-control" value="{{ $curso->nivel }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Letra</label>
                        <input type="text" name="letra" class="form-control" maxlength="1" value="{{ $curso->letra }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ciclo</label>
                        <select name="id_ciclo" class="form-select" required>
                            @foreach($ciclos as $ciclo)
                                <option value="{{ $ciclo->id }}" {{ $curso->id_ciclo == $ciclo->id ? 'selected' : '' }}>
                                    {{ $ciclo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profesor Jefe</label>
                        <select name="id_profesor_jefe" class="form-select" required>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}" {{ $curso->id_profesor_jefe == $profesor->id ? 'selected' : '' }}>
                                    {{ $profesor->nombre }} {{ $profesor->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
                <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection