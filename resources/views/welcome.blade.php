@extends('layouts.app')

@section('content')
<style>
    /* Definición de la paleta de colores del Colegio San Vicente */
    :root {
        --sv-blue: #3b4cca;       /* Azul base de la insignia */
        --sv-blue-dark: #2a3a9c;  /* Un tono más oscuro para contraste */
        --sv-gold: #fcd34d;       /* Amarillo dorado de los bordes y sol */
        --sv-gold-light: #fff3c4; /* Un dorado muy suave para fondos */
        --sv-coral: #f87171;      /* Rosa coral de la antorcha */
    }

    .bg-colegio {
        background: linear-gradient(135deg, var(--sv-blue) 0%, var(--sv-blue-dark) 100%);
    }

    .text-gold {
        color: var(--sv-gold);
    }

    .border-gold-lg {
        border: 4px solid var(--sv-gold);
        border-radius: 25px;
    }

    .sv-card {
        border: 1px solid rgba(0,0,0,0.1);
        border-top: 5px solid var(--sv-blue);
        transition: transform 0.2s ease;
    }

    .sv-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
    }

    .sv-icon {
        background-color: var(--sv-gold-light);
        color: var(--sv-blue);
    }
</style>

<div class="bg-colegio py-5 shadow-sm" style="color: white; border-radius: 0 0 40px 40px;">
    <div class="container py-4">
        <div class="row align-items-center">
            
            <div class="col-lg-7 text-center text-lg-start mb-5 mb-lg-0">
                <span class="badge bg-light text-sv-blue px-3 py-2 mb-3 fw-bold shadow-sm text-uppercase" style="color: var(--sv-blue);">Año Académico 2026</span>
                
                <h1 class="display-3 fw-bold mb-3">Plataforma Educativa</h1>
                <h2 class="display-5 text-gold mb-4 fw-light">Colegio Básico San Vicente</h2>
                
                <p class="lead mb-5 opacity-90" style="max-width: 600px;">
                    Un espacio integral para la gestión escolar, optimizando la comunicación entre docentes, administrativos y la comunidad de <span class="fw-bold">Talcahuano</span>.
                </p>
                
                <div class="d-grid gap-3 d-md-flex justify-content-center justify-content-lg-start">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light btn-lg px-5 fw-bold shadow text-sv-blue" style="color: var(--sv-blue);">
                            <span class="me-2">🚪</span>Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-5">
                                Registrarse
                            </a>
                        @endif
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg px-5 fw-bold shadow text-sv-blue" style="color: var(--sv-blue);">
                            <span class="me-2">📊</span>Panel de Control
                        </a>
                    @endguest
                </div>
            </div>

            <div class="col-lg-5 text-center">
                <div class="p-3 bg-white d-inline-block shadow-lg" style="border-radius: 30px;">
                    <img src="{{ asset('images/logo.png') }}" alt="Insignia Colegio Básico San Vicente Talcahuano" 
                         class="img-fluid" style="max-height: 380px; filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5 mt-n5">
    <div class="row g-4 justify-content-center">
        
        <div class="col-md-4">
            <div class="card h-100 sv-card shadow p-3">
                <div class="card-body">
                    <div class="feature-icon sv-icon mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 20px; font-size: 2rem;">
                        👥
                    </div>
                    <h5 class="fw-bold text-center mb-3">Registro de Alumnos</h5>
                    <p class="text-muted text-center mb-0">Gestión de matrículas, fichas personales y datos académicos de la comunidad estudiantil.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 sv-card shadow p-3">
                <div class="card-body">
                    <div class="feature-icon sv-icon mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 20px; font-size: 2rem;">
                        <span style="color: var(--sv-coral);">📖</span>
                    </div>
                    <h5 class="fw-bold text-center mb-3">Calificaciones</h5>
                    <p class="text-muted text-center mb-0">Ingreso detallado y seguimiento del rendimiento académico por asignatura y nivel.</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 sv-card shadow p-3">
                <div class="card-body">
                    <div class="feature-icon sv-icon mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 20px; font-size: 2rem;">
                        👨‍🏫
                    </div>
                    <h5 class="fw-bold text-center mb-3">Equipo Docente</h5>
                    <p class="text-muted text-center mb-0">Administración de la planta de profesores jefes y especialistas del colegio.</p>
                </div>
            </div>
        </div>
        
    </div>
</div>

<footer class="py-5 mt-5 text-center text-muted" style="background-color: #f8f9fa;">
    <div class="container">
        <img src="{{ asset('images/logo.png') }}" alt="Logo San Vicente" class="mb-3" style="max-height: 50px; opacity: 0.6;">
        <p class="fw-bold text-colegio mb-1">Colegio Básico San Vicente - Talcahuano</p>
        <p class="small">&copy; {{ date('Y') }} Plataforma de Gestión Interna. Todos los derechos reservados.</p>
    </div>
</footer>
@endsection