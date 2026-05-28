<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Asignatura;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_alumnos'    => Alumno::count(),
            'total_profesores' => Profesor::count(),
            'total_cursos'     => Curso::count(),
            'total_materias'   => Asignatura::count(),
        ];

        return view('dashboard', compact('stats'));
    }
}