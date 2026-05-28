@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Tabla de Profesores -->
        <div class="table-responsive">

            <!-- Panel de Profesores -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header card-header-sv">
                    <h5 class="mb-0">👨‍🏫 Profesores</h5>

                </div>
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="m-0">Filtrar</h3>

                        <form action="{{ route('profesores.index') }}" method="GET" class="d-flex w-50">
                            <input type="text" name="buscar" class="form-control "
                                placeholder="Buscar por Nombre, Apellido o RUT..." value="{{ $buscar ?? '' }}">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i> Buscar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <br>

            <div class="d-flex justify-content-end align-items-center gap-3 mb-3">
                <div class="form-check form-switch p-2 px-3 rounded border bg-light shadow-sm m-0">
                    <input class="form-check-input ms-0 me-2" type="checkbox" id="filtroInactivos"
                        onchange="filtrarTabla()">
                    <label class="form-check-label fw-bold text-secondary" for="filtroInactivos">
                        <i class="bi bi-eye-slash me-1"></i> Ocultar Inactivos
                    </label>
                </div>

                <button type="button" class="btn btn-sv shadow-sm m-0" data-bs-toggle="modal"
                    data-bs-target="#modalProfesor">
                    <i class="bi bi-person-plus me-1"></i> Nuevo Profesor
                </button>
            </div>



            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header card-header-sv">
                    <h5 class="mb-0">Listado Profesores</h5>

                </div>
                <div class="card-body">

                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">RUT</th>
                                <th>Nombre Completo</th>
                                <th>Especialidad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tablaProfesoresBody">
                            @forelse($profesores as $profesor)
                                <tr id="profesor-{{ $profesor->id }}"
                                    class="align-middle {{ $profesor->estado == 0 ? 'fila-inactiva' : '' }}">
                                    <td>{{ $profesor->rut }}</td>
                                    <td>{{ $profesor->nombres }} {{ $profesor->apellidos }}</td>
                                    <td>{{ $profesor->especialidad }}</td>
                                    <td id="estado-badge-{{ $profesor->id }}">
                                        @if ($profesor->estado == 1)
                                            <span
                                                class="badge rounded-pill bg-success-subtle text-success border border-success">
                                                <i class="bi bi-check-circle me-1"></i> Activo
                                            </span>
                                        @else
                                            <span
                                                class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary">
                                                <i class="bi bi-x-circle me-1"></i> Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-right align-items-right gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-warning"
                                                onclick="abrirModalEditar({{ json_encode($profesor) }})">
                                                <i class="bi bi-pencil-square me-1"></i> Editar
                                            </button>

                                            <button type="button" id="btn-estado-{{ $profesor->id }}"
                                                class="btn btn-sm {{ $profesor->estado == 1 ? 'btn-danger' : 'btn-success' }} d-flex align-items-center"
                                                onclick="toggleBaja({{ $profesor->id }})">
                                                @if ($profesor->estado == 1)
                                                    <i class="bi bi-person-x me-1"></i> Deshabilitar
                                                @else
                                                    <i class="bi bi-person-check me-1"></i> Activar
                                                @endif
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay registros.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $profesores->appends(['buscar' => $buscar])->links() }}
                    </div>
                </div>
            </div>



        </div>
    </div>


    <!-- #region Modal para Registrar Profesor -->
    <!-- -------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------------------------------------------------------------->

    <div class="modal fade" id="modalProfesor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content registro-container border-0">

                <div class="registro-header">
                    <h5 class="modal-title">Registrar Profesor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formProfesor" action="{{ route('profesores.store') }}" method="POST">
                    @csrf

                    <div class="registro-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>RUN *</label>
                                    <div class="input-container w-100">
                                        <input type="text" name="rut" class="form-control form-control-sm" required>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Nombres *</label>
                                    <input type="text" name="nombres" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Apellidos *</label>
                                    <input type="text" name="apellidos" class="form-control form-control-sm" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Especialidad *</label>
                                    <input type="text" name="especialidad" class="form-control form-control-sm"
                                        placeholder="Ej: Matemáticas" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Telefono </label>
                                    <input type="number" name="telefono" class="form-control form-control-sm" >
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Fecha Nacimiento </label>
                                    <input type="date" name="fecha_nacimiento" class="form-control form-control-sm" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Email Personal </label>
                                    <div class="input-container w-100">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">@</span>
                                            <input type="email" name="email_personal" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Calle</label>
                                    <input type="text" name="calle" class="form-control form-control-sm" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>numero</label>
                                    <input type="text" name="numero" class="form-control form-control-sm" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Comuna</label>
                                    <input type="text" name="comuna" class="form-control form-control-sm" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Ciudad</label>
                                    <input type="text" name="ciudad" class="form-control form-control-sm" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Region</label>
                                    <input type="text" name="region" class="form-control form-control-sm" >
                                </div>
                            </div>

                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Password *</label>
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group-row">
                                    <label>Email Institucional *</label>
                                    <div class="input-container w-100">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">@</span>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="registro-footer">
                        <button type="submit" class="btn btn-sm btn-sv">Añadir</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- #region Modal para Editar Profesor -->
    <!-- -------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------------------------------------------------------------->

    <div class="modal fade" id="modalEditarProfesor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content registro-container border-0">
                <div class="registro-header">
                    <h5 class="modal-title">Actualizar registro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditarProfesor">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit_id">
                    <div class="registro-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-row">
                                    <label>RUN</label>
                                    <div class="input-container w-100">
                                        <input type="text" id="edit_rut" name="rut"
                                            class="form-control form-control-sm " readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-row">
                                    <label>Nombre</label>
                                    <div class="input-container w-100">
                                        <input type="text" id="edit_nombre" name="nombre"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-row">
                                    <label>Apellido</label>
                                    <div class="input-container w-100">
                                        <input type="text" id="edit_apellido" name="apellido"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group-row">
                                    <label>Especialidad</label>
                                    <div class="input-container w-100">
                                        <input type="text" id="edit_especialidad" name="especialidad"
                                            class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="registro-footer">
                        <button type="submit" class="btn btn-sm btn-sv">Actualizar</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- -------------------------------------------------------------------------------------------------------------------->
    <!-- -------------------------------------------------------------------------------------------------------------------->

    <script>
        // --- 1. REGISTRAR NUEVO PROFESOR ---
        /*
        document.getElementById('formProfesor').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('{{ route('profesores.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.status === 422) { // Errores de validación (RUT/Email duplicado)
                        return response.json().then(data => {
                            displayErrors(data.errors);
                            throw 'validation_error';
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        location.reload(); // Recargamos para ver el nuevo registro con toda su lógica
                    }
                })
                .catch(err => {
                    if (err !== 'validation_error') console.error(err);
                });
        });
        */
        // --- 2. EDITAR PROFESOR ---
        function abrirModalEditar(profesor) {
            document.getElementById('edit_id').value = profesor.id;
            document.getElementById('edit_rut').value = profesor.rut;
            document.getElementById('edit_nombre').value = profesor.nombres;
            document.getElementById('edit_apellido').value = profesor.apellidos;
            document.getElementById('edit_especialidad').value = profesor.especialidad;
            new bootstrap.Modal(document.getElementById('modalEditarProfesor')).show();
        }

        document.getElementById('formEditarProfesor').addEventListener('submit', function(e) {
            e.preventDefault();
            const id = document.getElementById('edit_id').value;
            fetch(`{{ url('profesores') }}/${id}`, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('modalEditarProfesor')).hide();
                        const fila = document.getElementById(`profesor-${id}`);
                        fila.cells[1].innerText = `${data.profesor.nombres} ${data.profesor.apellidos}`;
                        fila.cells[2].innerText = data.profesor.especialidad;
                        alert("Actualizado con éxito");
                    }
                });
        });

        // --- 3. CAMBIAR ESTADO (DAR DE BAJA / ACTIVAR) ---
        function toggleBaja(id) {
            fetch(`{{ url('profesores') }}/${id}/baja`, {
                    method: 'PATCH',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const fila = document.getElementById(`profesor-${id}`);
                        const badge = document.getElementById(`estado-badge-${id}`);
                        const btn = document.getElementById(`btn-estado-${id}`); // Necesitarás agregar este ID al botón

                        if (data.nuevoEstado == 0) {
                            // Estado Inactivo (Gris)
                            fila.classList.add('fila-inactiva');
                            badge.innerHTML = `
                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border border-secondary">
                        <i class="bi bi-x-circle me-1"></i> Inactivo
                    </span>`;
                            if (btn) {
                                btn.className = 'btn btn-sm btn-success d-flex align-items-center';
                                btn.innerHTML = '<i class="bi bi-person-check me-1"></i> Activar';
                            }
                        } else {
                            // Estado Activo (Verde con Check)
                            fila.classList.remove('fila-inactiva');
                            badge.innerHTML = `
                    <span class="badge rounded-pill bg-success-subtle text-success border border-success">
                        <i class="bi bi-check-circle me-1"></i> Activo
                    </span>`;
                            if (btn) {
                                btn.className = 'btn btn-sm btn-danger d-flex align-items-center';
                                btn.innerHTML = '<i class="bi bi-person-x me-1"></i> Deshabilitar';
                            }
                        }

                        // CADA VEZ QUE CAMBIAMOS EL ESTADO, VOLVEMOS A APLICAR EL FILTRO PARA QUE SI ESTÁ INACTIVO Y EL FILTRO ESTÁ ACTIVADO, SE OCULTE INMEDIATAMENTE
                        // Si el filtro está activado, ocultamos la fila inmediatamente si pasó a inactiva
                        filtrarTabla();

                    }
                })
                .catch(error => console.error('Error:', error));
        }


        // --- 4. FILTRAR TABLA DE PROFESORES INACTIVOS ---
        function filtrarTabla() {
            // Obtenemos el estado del checkbox
            const ocultar = document.getElementById('filtroInactivos').checked;

            // Seleccionamos todas las filas que tienen la clase de inactividad
            const filasInactivas = document.querySelectorAll('.fila-inactiva');

            filasInactivas.forEach(fila => {
                if (ocultar) {
                    // Aplicamos un efecto de desvanecimiento antes de ocultar
                    fila.style.transition = "opacity 0.3s ease";
                    fila.style.opacity = "0";
                    setTimeout(() => {
                        if (document.getElementById('filtroInactivos').checked) {
                            fila.style.display = 'none';
                        }
                    }, 300);
                } else {
                    // Volvemos a mostrar la fila
                    fila.style.display = '';
                    setTimeout(() => {
                        fila.style.opacity = "1";
                    }, 10);
                }
            });
        }



        // --- FUNCIÓN AUXILIAR PARA ERRORES ---
        function displayErrors(errors) {
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

            Object.keys(errors).forEach(key => {
                const input = document.querySelector(`[name="${key}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback d-block';
                    errorDiv.innerText = errors[key][0];

                    // Si es un input-group (como el email), lo ponemos después del grupo
                    const container = input.closest('.input-group') || input.closest('.input-container') || input;
                    container.after(errorDiv);
                }
            });
        }
    </script>

    </script>
@endsection
