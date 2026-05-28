<nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
    style="background-color: #3b5c8a; border-bottom: 4px solid #fcd34d; font-family: 'Open Sans', sans-serif;">
    <div class="container">


        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo2.png') }}" alt="Logo" width="200" height="50"
                class="d-inline-block align-top me-2">

        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                @if (Auth::user()->role === 'admin')
                @endif


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-bold text-white" href="#" id="navbarDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid-fill me-1"></i> Gestión Académica
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0" aria-labelledby="navbarDropdown">
                        <li>
                            <h6 class="dropdown-header text-primary">Personal y Alumnos</h6>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('profesores.index') }}"><i
                                    class="bi bi-person-badge me-2"></i> Profesores</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('alumnos.index') }}"><i
                                    class="bi bi-people me-2"></i> Alumnos</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <h6 class="dropdown-header text-primary">Organización</h6>
                        </li>
                        <li><a class="dropdown-item py-2" href="{{ route('cursos.index') }}"><i
                                    class="bi bi-mortarboard me-2"></i> Cursos</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('asignaturas.index') }}"><i
                                    class="bi bi-book me-2"></i> Asignaturas</a></li>
                        <li><a class="dropdown-item py-2" href="{{ route('ciclos.index') }}"><i
                                    class="bi bi-calendar-range me-2"></i> Ciclos</a></li>
                    </ul>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="userDropdown"
                        role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Mi Perfil</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Cerrar Sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
