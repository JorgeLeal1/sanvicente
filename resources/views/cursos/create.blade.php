@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Crear Nuevo Curso</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('cursos.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nivel" class="form-label">Nivel (Ej: 1ro, 2do)</label>
                        <input type="text" name="nivel" class="form-control" placeholder="Ej: Primero" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="letra" class="form-label">Letra</label>
                        <input type="text" name="letra" class="form-control" maxlength="1" placeholder="A" required>
                    </div>
                    <div class="col-md-4">
                        <label for="anio_id">Año Académico</label>
                        <select id="anio_id" class="form-control">
                            <option value="">Seleccione un año</option>
                            @foreach($anios as $a)
                                <option value="{{ $a->id }}">{{ $a->anio_valor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="semestre_id">Semestre</label>
                        <select id="semestre_id" class="form-control" disabled>
                            <option value="">Seleccione un semestre</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="ciclo_id">Ciclo</label>
                        <select name="ciclo_id" id="ciclo_id" class="form-control" disabled required>
                            <option value="">Seleccione un ciclo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="profesor_jefe_id" class="form-label">Profesor Jefe</label>
                        <select name="profesor_jefe_id" class="form-select" required>
                            <option value="">Seleccione un profesor</option>
                            @foreach($profesores as $profesor)
                                <option value="{{ $profesor->id }}">{{ $profesor->nombre }} {{ $profesor->apellido }}, {{ $profesor->especialidad }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Guardar Curso</button>
                    <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
   
    document.addEventListener('DOMContentLoaded', function() {
    const selectAnio = document.getElementById('anio_id');
    const selectSemestre = document.getElementById('semestre_id');
    const selectCiclo = document.getElementById('ciclo_id');


    // 1. Cuando cambia el Año -> Cargar Semestres
    selectAnio.addEventListener('change', function() {
        const anioId = this.value;
        selectSemestre.innerHTML = '<option value="">Cargando...</option>';
        selectCiclo.innerHTML = '<option value="">Seleccione un ciclo</option>';
        selectCiclo.disabled = true;


        if (anioId) {
            fetch(`{{ url('get-semestres') }}/${anioId}`) // <--  comillas invertidas ` para permitir interpolación de variables
                .then(res => res.json())
                .then(data => {
                    selectSemestre.innerHTML = '<option value="">Seleccione un semestre</option>';
                    data.forEach(s => {
                        selectSemestre.innerHTML += `<option value="${s.id}">${s.nombre}</option>`;
                    });
                    selectSemestre.disabled = false;
                });
        }
    });

    // 2. Cuando cambia el Semestre -> Cargar Ciclos
    selectSemestre.addEventListener('change', function() {
        const semestreId = this.value;
        selectCiclo.innerHTML = '<option value="">Cargando...</option>';

        if (semestreId) {
            fetch(`{{ url('get-ciclos') }}/${semestreId}`) // <--  comillas invertidas ` para permitir interpolación de variables
                .then(res => res.json())
                .then(data => {
                    selectCiclo.innerHTML = '<option value="">Seleccione un ciclo</option>';
                    data.forEach(c => {
                        selectCiclo.innerHTML += `<option value="${c.id}">${c.nombre}</option>`;
                    });
                    selectCiclo.disabled = false;
                });
        }
    });
});
</script>


@endsection