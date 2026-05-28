@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">

<form action="{{ route('asignaturas.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-md-3">
            <label>Año</label>
            <select id="anio_id" class="form-control mb-3">
                <option value="">Seleccione Año</option>
                @foreach($anios as $a) <option value="{{ $a->id }}">{{ $a->anio }}</option> @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Semestre</label>
            <select id="semestre_id" class="form-control mb-3" disabled><option>...</option></select>
        </div>
        <div class="col-md-3">
            <label>Ciclo</label>
            <select id="ciclo_id" class="form-control mb-3" disabled><option>...</option></select>
        </div>
        <div class="col-md-3">
            <label>Curso Destino</label>
            <select name="curso_id" id="curso_id" class="form-control mb-3" disabled required>
                <option value="">Seleccione Curso</option>
            </select>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <label>Nombre de la Asignatura</label>
            <input type="text" name="nombre_asignatura" class="form-control" placeholder="Ej: Lenguaje y Comunicación" required>
        </div>
        <div class="col-md-6">
            <label>Profesor a Cargo</label>
            <select name="user_id" class="form-control" required>
                <option value="">Seleccione Profesor</option>
                @foreach($profesores as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} {{ $p->apellido }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Registrar Asignatura</button>
</form>

</div>
</div>

<script>

    const anio = document.getElementById('anio_id');
    const semestre = document.getElementById('semestre_id');
    const ciclo = document.getElementById('ciclo_id');
    const curso = document.getElementById('curso_id');

    anio.addEventListener('change', () => cargarData(anio.value, semestre, 'get-semestres', 'Semestre'));
    semestre.addEventListener('change', () => cargarData(semestre.value, ciclo, 'get-ciclos', 'Ciclo'));
    ciclo.addEventListener('change', () => cargarData(ciclo.value, curso, 'get-cursos', 'Curso'));

    function cargarData(id, element, route, label) {
        element.innerHTML = '<option>Cargando...</option>';
        element.disabled = true;
        
        if(!id) return;

        fetch(`/${route}/${id}`)
            .then(res => res.json())
            .then(data => {
                element.innerHTML = `<option value="">Seleccione ${label}</option>`;
                data.forEach(item => {
                    // Adaptamos según si el objeto tiene 'nombre' o 'nivel/letra'
                    let texto = item.nombre ? item.nombre : `${item.nivel} ${item.letra}`;
                    element.innerHTML += `<option value="${item.id}">${texto}</option>`;
                });
                element.disabled = false;
            });
    }
</script>


@endsection