<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Evaluacion;
use App\Models\Curso;
use App\Models\Asignatura;

class NotaController extends Controller
{
    public function index(Request $request)
    {
        $cursos = Curso::all();
        $alumnos = Alumno::all(); 
        $asignaturas = Asignatura::all();
        
        // Consulta básica con relaciones para que sea rápido
        $query = Evaluacion::with(['alumno.curso']);

        // Si el usuario filtra por curso
        if ($request->filled('curso')) {
            $query->whereHas('alumno', function($q) use ($request) {
                $q->where('id_curso', $request->curso);
            });
        }

        $notas = $query->latest()->get();

        return view('notas.index', compact('notas', 'cursos', 'alumnos', 'asignaturas'));
    }

    // Retorna alumnos para AJAX
    public function getAlumnos($curso_id) {
        $alumnos = Alumno::where('id_curso', $curso_id)->get();
        return response()->json($alumnos);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cursos = Curso::all();
        $alumnos = Alumno::all(); // OJO: Después podemos filtrar alumnos por curso con JavaScript
        return view('notas.create', compact('cursos', 'alumnos'));
    }

    /**
     * Store a newly created resource in storage.
    */
    // Guarda la nota vía AJAX
    public function store(Request $request) {
        $nota = Evaluacion::create([
            'valor' => $request->valor,
            'fecha' => now(),
            'id_alumno' => $request->id_alumno,
            'id_asignatura' => $request->id_asignatura,
            'id_semestre' => 1 // Podrías hacerlo dinámico
        ]);

        return response()->json(['success' => 'Nota guardada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}