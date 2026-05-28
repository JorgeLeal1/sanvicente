<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Anio_academico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Reporte general del colegio
     */
    public function dashboard()
    {
        $data = [
            'total_alumnos'     => Alumno::count(),
            'total_profesores'  => Profesor::count(),
            'total_cursos'      => Curso::count(),
            'anio_actual'       => Anio_academico::where('estado', true)->latest()->first(),
            
            'alumnos_por_curso' => DB::table('vista_alumnos_por_curso')
                                    ->where('anio_valor', 2026)
                                    ->get(),
            
            'mejores_alumnos'   => DB::table('vista_rendimiento_alumnos')
                                    ->orderBy('promedio', 'desc')
                                    ->take(10)
                                    ->get(),
        ];

        return view('reportes.dashboard', $data);
    }

    /**
     * 1. Alumnos por Curso y Año
     */
    public function alumnosPorCurso(Request $request)
    {
        $anioId = $request->get('anio_academico_id', Anio_academico::latest()->first()->id ?? 1);

        $alumnos = DB::table('vista_alumnos_por_curso')
                     ->where('anio_valor', $anioId)
                     ->get();

        $anios = Anio_academico::orderBy('anio_valor', 'desc')->get();

        return view('reportes.alumnos-por-curso', compact('alumnos', 'anios'));
    }

    /**
     * 2. Rendimiento Académico
     */
    public function rendimientoAcademico(Request $request)
    {
        $query = DB::table('vista_rendimiento_alumnos');

        if ($request->has('curso_id')) {
            $query->where('nivel', 'like', '%' . $request->curso_id . '%');
        }

        $rendimiento = $query->orderBy('promedio', 'desc')->paginate(20);

        return view('reportes.rendimiento-academico', compact('rendimiento'));
    }

    /**
     * 3. Carga Académica de Profesores
     */
    public function cargaProfesores(Request $request)
    {
        $anio = $request->get('anio', 2026);

        $carga = DB::table('vista_carga_profesores')
                   ->where('anio_valor', $anio)
                   ->orderBy('total_alumnos', 'desc')
                   ->get();

        return view('reportes.carga-profesores', compact('carga'));
    }

    /**
     * 4. Reporte de Asistencia
     */
    public function asistencia(Request $request)
    {
        $asistencia = DB::table('vista_asistencia')
                        ->orderBy('porcentaje_asistencia', 'desc')
                        ->paginate(15);

        return view('reportes.asistencia', compact('asistencia'));
    }

    /**
     * 5. Ranking General de Alumnos
     */
    public function rankingAlumnos()
    {
        $ranking = DB::table('vista_rendimiento_alumnos')
                     ->selectRaw('nombre_completo, nivel, letra, ROUND(AVG(promedio), 2) as promedio_general')
                     ->groupBy('nombre_completo', 'nivel', 'letra')
                     ->orderBy('promedio_general', 'desc')
                     ->take(50)
                     ->get();

        return view('reportes.ranking-alumnos', compact('ranking'));
    }

    /**
     * 6. Alumnos con Bajo Rendimiento (En riesgo)
     */
    public function alumnosEnRiesgo()
    {
        $riesgo = DB::table('vista_rendimiento_alumnos')
                    ->where('promedio', '<', 4.0)
                    ->orderBy('promedio', 'asc')
                    ->get();

        return view('reportes.alumnos-en-riesgo', compact('riesgo'));
    }
}