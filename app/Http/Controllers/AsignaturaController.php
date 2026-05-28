<?php

namespace App\Http\Controllers;
use App\Models\Asignatura;
use App\Models\Curso;
use \App\Models\Anio_academico;
use Illuminate\Http\Request;

class AsignaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Datos para llenar el primer select
    $anios = Anio_academico::orderBy('anio_valor', 'desc')->get();
    
    // Captura de parámetros
    $f_curso = $request->get('curso_id');
    $f_ciclo = $request->get('ciclo_id');
    $f_semestre = $request->get('semestre_id');
    $f_anio = $request->get('anio_id');

    // Consulta con Eager Loading para evitar lentitud
    $query = Asignatura::with(['curso.ciclo.semestre.anioAcademico', 'user']);

    // Filtros en cadena
    if ($f_curso) {
        $query->where('curso_id', $f_curso);
    } elseif ($f_ciclo) {
        $query->whereHas('curso', fn($q) => $q->where('ciclo_id', $f_ciclo));
    } elseif ($f_semestre) {
        $query->whereHas('curso.ciclo', fn($q) => $q->where('semestre_id', $f_semestre));
    } elseif ($f_anio) {
        $query->whereHas('curso.ciclo.semestre', fn($q) => $q->where('anios_academicos_id', $f_anio));
    }

    $asignaturas = $query->paginate(10);

    return view('asignaturas.index', compact('asignaturas', 'anios'));
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('asignaturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_asignatura' => 'required|string|max:255',
            'curso_id' => 'required|exists:cursos,id',
            'user_id' => 'required|exists:users,id',
        ]);

        Asignatura::create($request->all());
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura creada con éxito');
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

    // Método para el selector dinámico
    public function getCursos($cicloId)
    {
        return Curso::where('ciclo_id', $cicloId)
                    ->select('id', 'nivel', 'letra')
                    ->get();
    }
}
