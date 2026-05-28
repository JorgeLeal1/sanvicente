<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CicloController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AnioController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SemestreController;




use Illuminate\Support\Facades\Route;

// 1. PÁGINA PÚBLICA
Route::get('/', function () {
    return view('welcome');
});

// 2. RUTAS PARA USUARIOS AUTENTICADOS (ADMIN Y PROFESOR)
Route::middleware(['auth', 'verified'])->group(function () {

    // --- SELECCIÓN DE PERIODO ---
    // Estas rutas NO deben tener 'check.period' para evitar bucles infinitos
    Route::get('/select-period', [PeriodoController::class, 'showSelector'])->name('period.select');
    Route::post('/select-period', [PeriodoController::class, 'store'])->name('period.store');
    
    // Rutas para los SELECT dinámicos (AJAX)
    Route::get('/get-semestres/{id}', [PeriodoController::class, 'getSemestres']);
    Route::get('/get-ciclos/{id}', [PeriodoController::class, 'getCiclos']);
    Route::get('/get-cursos/{id}', [AsignaturaController::class, 'getCursos']);

    // --- PERFIL DE USUARIO ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- RUTAS PROTEGIDAS POR SELECCIÓN DE PERIODO ---
    // Solo se accede aquí si ya pasó por el Middleware 'check.period'
    Route::middleware(['check.period'])->group(function () {
        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Rutas compartidas (Ambos roles, filtradas internamente por periodo)
        Route::resource('notas', NotaController::class);
        Route::resource('cursos', CursoController::class);
        Route::resource('ciclos', CicloController::class);

        // --- RUTAS EXCLUSIVAS DEL ADMINISTRADOR ---
        // Usamos una función anónima o un middleware de rol si lo tienes creado
        Route::middleware(['admin'])->group(function () {
            
            // Gestión Académica
            Route::get('/configuracion/anios', [AnioController::class, 'create'])->name('anios.create');
            Route::post('/configuracion/anios', [AnioController::class, 'store'])->name('anios.store');
            Route::delete('/configuracion/anios/{id}', [AnioController::class, 'destroy'])->name('anios.destroy');    
            Route::patch('/configuracion/anios/{id}/toggle', [AnioController::class, 'toggleStatus'])->name('anios.toggle');

            // Recursos maestros
            Route::resource('profesores', ProfesorController::class);
            Route::patch('/profesores/{id}/baja', [ProfesorController::class, 'darDeBaja'])->name('profesores.baja');
            Route::resource('alumnos', AlumnoController::class);
            Route::resource('anios', AnioController::class);
            Route::resource('asignaturas', AsignaturaController::class);
        });
    });
});


Route::prefix('reportes')->name('reportes.')->group(function () {
    Route::get('/', [ReporteController::class, 'dashboard'])->name('dashboard');
    Route::get('/alumnos-por-curso', [ReporteController::class, 'alumnosPorCurso'])->name('alumnos-por-curso');
    Route::get('/rendimiento', [ReporteController::class, 'rendimientoAcademico'])->name('rendimiento');
    Route::get('/carga-profesores', [ReporteController::class, 'cargaProfesores'])->name('carga-profesores');
    Route::get('/asistencia', [ReporteController::class, 'asistencia'])->name('asistencia');
    Route::get('/ranking', [ReporteController::class, 'rankingAlumnos'])->name('ranking');
    Route::get('/en-riesgo', [ReporteController::class, 'alumnosEnRiesgo'])->name('en-riesgo');
});


// Rutas de Semestres
Route::resource('semestres', SemestreController::class);

Route::prefix('semestres')->name('semestres.')->group(function () {
    Route::get('/create', [SemestreController::class, 'create'])->name('create');
    Route::post('/', [SemestreController::class, 'store'])->name('store');
    
    // Ruta adicional para clonar directamente un semestre específico
    Route::post('/{semestre}/clonar', [SemestreController::class, 'clonar'])
         ->name('clonar');
});



require __DIR__.'/auth.php';