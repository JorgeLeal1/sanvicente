@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-5">
            <form action="{{ route('anios.store') }}" method="POST" class="card shadow border-0">
                @csrf
                <div class="card-header bg-primary text-white fw-bold">Registrar Año y Semestres</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="anio_valor" class="form-label">Seleccionar Año Académico</label>
                        <select name="anio_valor" id="anio_valor" class="form-control" required>
                            <option value="">-- Seleccione un año --</option>
                            @foreach($aniosDisponibles as $anioOp)
                                <option value="{{ $anioOp }}">{{ $anioOp }}</option>
                            @endforeach
                        </select>
                    </div>

                    <h6 class="fw-bold mt-4 border-bottom pb-2">Semestres del Año</h6>
                    <div id="contenedor-semestres">
                        <div class="input-group mb-2 semestre-item">
                            <input type="text" name="semestres[0][nombre]" class="form-control" placeholder="Primer Semestre" required>
                            <button type="button" class="btn btn-outline-danger disabled">X</button>
                        </div>
                    </div>
                    
                    <button type="button" id="btn-agregar-semestre" class="btn btn-sm btn-link text-success p-0 fw-bold">
                        + Agregar otro semestre
                    </button>

                    <button type="submit" class="btn btn-primary w-100 mt-4 fw-bold shadow-sm">Guardar Configuración</button>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>


        <div class="col-md-7">
            <div class="card shadow border-0">
                <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="m-0">Años Registrados</h4>
                
                <form action="{{ route('anios.create') }}" method="GET" class="d-flex w-50">
                    <input type="number" name="buscar" class="form-control form-control-sm me-2" 
                        placeholder="Buscar por año..." value="{{ $buscar }}">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="bi bi-search">buscar</i>
                    </button>
                </form>
            </div>
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Año</th>
                        <th>Semestres Asociados</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aniosRegistrados as $a)
                    <tr>
                        <td class="fw-bold">{{ $a->anio_valor }}</td>
                        <td>
                            @foreach($a->semestres as $s)
                                <span class="badge bg-info text-dark">{{ $s->nombre }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">
                            @if($a->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('anios.toggle', $a->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @if($a->activo)
                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-eye-slash"></i> Desactivar
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-eye"></i> Activar
                                    </button>
                                @endif
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $aniosRegistrados->appends(['buscar' => $buscar])->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let semestreIndex = 1;
    document.getElementById('btn-agregar-semestre').addEventListener('click', function() {
        const contenedor = document.getElementById('contenedor-semestres');
        const div = document.createElement('div');
        div.className = 'input-group mb-2 semestre-item';
        div.innerHTML = `
            <input type="text" name="semestres[${semestreIndex}][nombre]" class="form-control" placeholder="Siguiente Semestre" required>
            <button type="button" class="btn btn-outline-danger remove-item">X</button>
        `;
        contenedor.appendChild(div);
        semestreIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('.semestre-item').remove();
        }
    });
</script>
@endsection