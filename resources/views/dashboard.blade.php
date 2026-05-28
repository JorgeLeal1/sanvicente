@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #3b4cca 0%, #2a3a9c 100%); color: white; border-radius: 15px;">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="me-4 d-none d-md-block">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-height: 80px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));">
                    </div>
                    <div>
                        <h2 class="fw-bold mb-1">¡Bienvenido, {{ Auth::user()->name }}! 👋</h2>
                        <p class="mb-0 opacity-75">Panel de Gestión - Colegio Básico San Vicente (Talcahuano)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-bottom: 5px solid #3b4cca !important;">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">👥</div>
                    <h6 class="text-muted text-uppercase small fw-bold">Total Alumnos</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_alumnos'] ?? 0 }}</h2>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="{{ route('alumnos.index') }}" class="small fw-bold text-decoration-none" style="color: #3b4cca;">Ver listado →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-bottom: 5px solid #f87171 !important;">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">👨‍🏫</div>
                    <h6 class="text-muted text-uppercase small fw-bold">Profesores</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_profesores'] ?? 0 }}</h2>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="{{ route('profesores.index') }}" class="small fw-bold text-decoration-none" style="color: #f87171;">Gestionar equipo →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-bottom: 5px solid #fcd34d !important;">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">🏫</div>
                    <h6 class="text-muted text-uppercase small fw-bold">Cursos Activos</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_cursos'] ?? 0 }}</h2>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="{{ route('cursos.index') }}" class="small fw-bold text-decoration-none" style="color: #d97706;">Ver niveles →</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-bottom: 5px solid #10b981 !important;">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 1.5rem;">🔄</div>
                    <h6 class="text-muted text-uppercase small fw-bold">Ciclos</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total_ciclos'] ?? 0 }}</h2>
                </div>
                <div class="card-footer bg-transparent border-0 text-center pb-3">
                    <a href="{{ route('ciclos.index') }}" class="small fw-bold text-decoration-none" style="color: #10b981;">Configurar →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white fw-bold">Acciones Frecuentes</div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('alumnos.create') }}" class="list-group-item list-group-item-action">➕ Matricular nuevo alumno</a>
                    <a href="{{ route('profesores.create') }}" class="list-group-item list-group-item-action">👨‍🏫 Registrar docente</a>
                    <a href="{{ route('notas.index') }}" class="list-group-item list-group-item-action">📝 Ingresar calificaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection