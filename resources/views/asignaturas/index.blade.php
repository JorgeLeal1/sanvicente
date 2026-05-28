@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow"></div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Listado de Asignaturas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('asignaturas.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="small">Año</label>
                <select name="anio_id" id="anio_id" class="form-select form-select-sm">
                    <option value="">Todos</option>
                    @foreach($anios as $a)
                        <option value="{{ $a->id }}" {{ request('anio_id') == $a->id ? 'selected' : '' }}>{{ $a->anio_valor }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="small">Semestre</label>
                <select name="semestre_id" id="semestre_id" class="form-select form-select-sm" {{ !request('semestre_id') ? 'disabled' : '' }}>
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="small">Ciclo</label>
                <select name="ciclo_id" id="ciclo_id" class="form-select form-select-sm" {{ !request('ciclo_id') ? 'disabled' : '' }}>
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="small">Curso</label>
                <select name="curso_id" id="curso_id" class="form-select form-select-sm" {{ !request('curso_id') ? 'disabled' : '' }}>
                    <option value="">Todos</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-primary">Filtrar</button>
                <a href="{{ route('asignaturas.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Asignatura</th>
                <th>Curso</th>
                <th>Periodo</th>
                <th>Docente</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asignaturas as $asig)
            <tr>
                <td><strong>{{ $asig->nombre_asignatura }}</strong></td>
                <td>{{ $asig->curso->nivel }} {{ $asig->curso->letra }}</td>
                <td>
                    <span class="badge bg-light text-dark">
                        {{ $asig->curso->ciclo->semestre->anioAcademico->anio }} - {{ $asig->curso->ciclo->semestre->nombre }}
                    </span>
                </td>
                <td>{{ $asig->user->name }} {{ $asig->user->apellido }}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-info text-white"><i class="bi bi-pencil"></i></button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">No se encontraron asignaturas con los filtros seleccionados.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $asignaturas->appends(request()->query())->links() }}
</div>


</div>
</div>

<script>
    const selectors = {
        anio: document.getElementById('anio_id'),
        semestre: document.getElementById('semestre_id'),
        ciclo: document.getElementById('ciclo_id'),
        curso: document.getElementById('curso_id')
    };

    selectors.anio.addEventListener('change', () => updateCascade(selectors.anio.value, selectors.semestre, 'get-semestres', 'Semestre'));
    selectors.semestre.addEventListener('change', () => updateCascade(selectors.semestre.value, selectors.ciclo, 'get-ciclos', 'Ciclo'));
    selectors.ciclo.addEventListener('change', () => updateCascade(selectors.ciclo.value, selectors.curso, 'get-cursos', 'Curso'));


    function updateCascade(id, target, route, label) {
        target.innerHTML = `<option value="">Cargando ${label}...</option>`;
        target.disabled = true;

        console.log(`Cargando ${label} para ID:`, id);
        if (!id) {
            target.innerHTML = `<option value="">Todos</option>`;
            return;
        }

        // Usamos {{ url('/') }} para asegurar que la ruta incluir /sanvicente/public/ si es necesario
        // console.log(`Fetch URL:`, `{{ url('/') }}/${route}/${id}`);

       fetch(`{{ url('/') }}/${route}/${id}`) 
            .then(res => {
                if (!res.ok) throw new Error('Error en la red');
                return res.json();
            })
            .then(data => {
                target.innerHTML = `<option value="">Todos</option>`;
                data.forEach(item => {
                    let text = item.nombre ? item.nombre : `${item.nivel} ${item.letra}`;
                    target.innerHTML += `<option value="${item.id}">${text}</option>`;
                });
                target.disabled = false;
            })
            .catch(error => {
                console.error('Hubo un problema:', error);
                target.innerHTML = `<option value="">Error al cargar</option>`;
            });
    }
</script>


@endsection