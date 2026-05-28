@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Añadir Nuevo Ciclo Académico</h5>
                </div>
                <div class="card-body">
                <form action="{{ route('ciclos.store') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label>Año Académico</label>
                        <select id="anio_id" class="form-control">
                            <option value="">Seleccione un año</option>
                            @foreach($anios as $anio)
                                <option value="{{ $anio->id }}">{{ $anio->anio_valor }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Semestre</label>
                        <select name="semestre_id" id="semestre_id" class="form-control" disabled required>
                            <option value="">Seleccione un semestre</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Nombre del Ciclo (Ej: Media, Básica, Pre-Básica)</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ingrese nombre del ciclo" required>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar Ciclo</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('anio_id').addEventListener('change', function() {
    const anioId = this.value;
    const selectSemestre = document.getElementById('semestre_id');
    
    selectSemestre.innerHTML = '<option value="">Cargando...</option>';
    selectSemestre.disabled = true;

    console.log('Año seleccionado:', anioId);
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
</script>


@endsection