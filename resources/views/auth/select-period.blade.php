@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white text-center py-4">
                    <h4 class="fw-bold text-primary">Configuración de Trabajo</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('period.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="fw-bold">Año Académico</label>
                            <select name="anio_id" id="anio" class="form-select border-primary" required>
                                <option value="">Seleccione Año</option>
                                @foreach($anios as $anio)
                                    <option value="{{ $anio->id }}">{{ $anio->anio_valor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Semestre</label>
                            <select name="semestre_id" id="semestre" class="form-select" disabled required>
                                <option value="">Esperando año...</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold">Ciclo</label>
                            <select name="ciclo_id" id="ciclo" class="form-select" disabled required>
                                <option value="">Esperando semestre...</option>
                            </select>
                        </div>

                        <button type="submit" id="btn-entrar" class="btn btn-primary w-100 fw-bold shadow" disabled>
                            Ingresar al Panel
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('anio').addEventListener('change', function() {
    let anioId = this.value;
    let semestreSelect = document.getElementById('semestre');
    
    semestreSelect.innerHTML = '<option value="">Cargando semestres...</option>';
    semestreSelect.disabled = true;

    if (anioId) {
        fetch("{{ url('get-semestres') }}/" + anioId)
            .then(response => response.json())
            .then(data => {
                semestreSelect.innerHTML = '<option value="">Seleccione Semestre</option>';
                data.forEach(semestre => {
                    semestreSelect.innerHTML += `<option value="${semestre.id}">${semestre.nombre}</option>`;
                });
                semestreSelect.disabled = false;
            });
    }
});

document.getElementById('semestre').addEventListener('change', function() {
    let semestreId = this.value;
    let cicloSelect = document.getElementById('ciclo');
    
    cicloSelect.innerHTML = '<option value="">Cargando ciclos...</option>';
    cicloSelect.disabled = true;

    if (semestreId) {
        fetch("{{ url('get-ciclos') }}/" + semestreId)
            .then(response => response.json())
            .then(data => {
                cicloSelect.innerHTML = '<option value="">Seleccione Ciclo</option>';
                data.forEach(ciclo => {
                    cicloSelect.innerHTML += `<option value="${ciclo.id}">${ciclo.nombre}</option>`;
                });
                cicloSelect.disabled = false;
            });
    }
});

document.getElementById('ciclo').addEventListener('change', function() {
    document.getElementById('btn-entrar').disabled = !this.value;
});
</script>

@endsection