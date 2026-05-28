

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Colegio San Vicente</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

<style>

    /* 1. Fondo de la página (fuera del card) */
    body {
        background-color: #f4f7f6 !important; /* Gris claro para dar contraste */
    }

    /* 2. Estilo institucional para los MODALES */
    .registro-header {
        background-color: #3030c7 !important; /* Azul institucional */
        color: white !important;
        border-bottom: 4px solid #facc15 !important; /* Línea amarilla */
        padding: 1rem 1.5rem;
    }

    /* Asegurar que el botón de cerrar modal sea blanco */
    .registro-header .btn-close {
        filter: brightness(0) invert(1);
    }

    /* 3. Ajuste para que el Card de Profesores use el mismo estilo */
    .card-header-sv {
        background-color: #3030c7 !important;
        color: white !important;
        border-bottom: 4px solid #facc15 !important;
        border-radius: 8px 8px 0 0 !important;
    }

    /* Estilo para las filas inactivas (un gris que combine con el nuevo fondo) */
    .fila-inactiva {
        background-color: #edf2f7 !important;
        color: #a0aec0 !important;
    }
font-family: 'Open Sans', sans-serif;

    :root {
        --sv-azul: #1e40af;
        --sv-borde: #dee2e6;
        --sv-bg-header: #f8f9fa;
    }

    /* Contenedor tipo "Ingreso de Registro" */
    .registro-container {
        background: white;
        border: 1px solid var(--sv-borde);
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 900px;
        margin: 20px auto;
    }

    .registro-header {
        background-color: #3030c7 !important;
         color: white !important;
         border-bottom: 4px solid #facc15 !important;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .registro-header h5 {
        margin: 0;
        font-weight: 600;
    }

    .registro-body {
        padding: 30px;
    }

    /* Sub-sección "Datos de Instructor" */
    .section-label {
        font-size: 0.85rem;
        color: #666;
        border-bottom: 1px solid #eee;
        margin-bottom: 20px;
        padding-bottom: 5px;
    }

    /* Estilo de los Labels laterales como en tu imagen */
    .form-group-row {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .form-group-row label {
        width: 30%;
        text-align: right;
        margin-right: 15px;
        font-weight: bold;
        font-size: 0.9rem;
        color: #333;
    }

    .form-group-row .input-container {
        width: 70%;
    }

    /* Botones alineados a la derecha */
    .registro-footer {
        padding: 15px 30px;
        background: #fdfdfd;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-sv {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 8px 20px;
    }

    .btn-sv:hover {
        background-color: #0d6efd;
        color: white;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #dc3545;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .input-container {
        display: flex;
        flex-direction: column;
    }


    /* Fila cuando el profesor está inactivo */
/* Estilo para filas inactivas */
    .fila-inactiva {
        background-color: #f8fafc !important; /* Gris muy claro */
        color: #94a3b8 !important; /* Texto gris */
        transition: all 0.3s ease;
    }
    .fila-inactiva td {
        opacity: 0.7;
    }
    /* Contenedor para que el error de validación siempre baje */
    .input-container {
        display: flex;
        flex-direction: column;
    }
    .invalid-feedback {
        font-size: 0.8rem;
        font-weight: 500;
    }


    /* Línea amarilla institucional debajo del encabezado de la tarjeta */
    .card-header-sv {
        background-color: #3030c7 !important; /* El azul de tu logo */
        color: white !important;
        border-bottom: 4px solid #facc15 !important; /* Línea amarilla de 4px */
        border-radius: 8px 8px 0 0 !important; /* Mantiene las esquinas redondeadas arriba */
    }
    
    /* Para que el título se vea más limpio */
    .card-header-sv h5 {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

/* Estilo para el menú desplegable */
    .dropdown-menu {
        border-top: 4px solid #facc15 !important; /* Línea amarilla institucional */
        border-radius: 0 0 8px 8px;
    }

    .dropdown-item:hover {
        background-color: #1e40af; /* Azul del colegio al pasar el mouse */
        color: white !important;
    }

    .dropdown-item i {
        color: #1e40af; /* Iconos azules por defecto */
    }

    .dropdown-item:hover i {
        color: #facc15; /* Iconos amarillos al pasar el mouse */
    }

    .dropdown-header {
        font-weight: 800;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
    }
    
    .navbar-brand img {
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
        transform: scale(1.05); /* Un pequeño efecto al pasar el mouse */
    }

    /* Estilo para las letras del colegio */
    .tracking-wider {
        font-size: 0.75rem;
        font-weight: 700;
        color: #facc15 !important; /* El amarillo institucional */
    }

    /* Ajuste de altura del Navbar para que el logo luzca */
    .navbar {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        min-height: 70px;
    }


</style>
</head>
<body>
    <div class="min-h-screen">
        
        @auth
            @include('layouts.navigation')
            @if(session('periodo_anio_valor'))
                <div class="py-2 shadow-sm" style="background-color: #3030c7; color: white;">
                    <div class="container d-flex justify-content-between align-items-center">
                        <div class="small fw-bold">
                            <span class="me-3">📅 AÑO: <span class="text-warning">{{ session('periodo_anio_valor') }}</span></span>
                            <span class="me-3">🌓 SEMESTRE: <span class="text-warning">{{ session('periodo_semestre_nombre') }}</span></span>
                            <span class="me-3">🏫 CICLO: <span class="text-warning">{{ session('periodo_ciclo_nombre') }}</span></span>
                        </div>
                        <a href="{{ route('period.select') }}" class="btn btn-xs btn-outline-light py-0 px-2" style="font-size: 0.7rem;">
                            CAMBIAR CONFIGURACIÓN
                        </a>
                    </div>
                </div>
                @endif
        @else
            <nav class="navbar navbar-dark navbar-sv shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="/">
                        <img src="{{ asset('images/logo.png') }}" width="30" class="me-2"> San Vicente
                    </a>
                </div>
            </nav>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>