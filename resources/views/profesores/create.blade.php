@extends('layouts.app')
@section('content')

<div class="container">

<div class="registro-container">
    <div class="registro-container">
    <div class="registro-header">
        <h5>Ingreso de registro</h5>
        <button type="button" class="btn-close" aria-label="Close"></button>
    </div>

    <form action="{{ route('profesores.store') }}" method="POST">
        @csrf
        <div class="registro-body">
            <div class="section-label">Datos de Instructor</div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-row">
                        <label>RUN</label>
                        <div class="input-container">
                            <input type="text" name="rut" class="form-control form-control-sm" required placeholder="12.345.678-9">
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label>Nombre</label>
                        <div class="input-container">
                            <input type="text" name="nombre" class="form-control form-control-sm" required>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-row">
                        <label>Apellido</label>
                        <div class="input-container">
                            <input type="text" name="apellido" class="form-control form-control-sm" required>
                        </div>
                    </div>

                    <div class="form-group-row">
                        <label>Email</label>
                        <div class="input-container">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">@</span>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group-row" style="margin-top: 10px;">
                        <label style="width: 15%;">Especialidad</label>
                        <div class="input-container" style="width: 85%;">
                            <input type="text" name="especialidad" class="form-control form-control-sm" placeholder="Ej: Matemáticas">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="registro-footer">
            <a href="{{ route('profesores.index') }}" class="btn btn-sm btn-outline-secondary">Cancelar</a>
            <button type="submit" class="btn btn-sm btn-sv">
                <i class="bi bi-person-plus me-1"></i> Añadir
            </button>
        </div>
    </form>
</div>

</div>
@endsection