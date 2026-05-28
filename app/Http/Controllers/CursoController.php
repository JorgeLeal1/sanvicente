<?php
namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Ciclo;
use App\Models\Anio_academico;
use \App\Models\User;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    /*
    public function index() {
        $cursos = Curso::with(['profesorJefe', 'ciclo'])->get();
        return view('cursos.index', compact('cursos'));
    }
    */
    public function index()
    {
        // Cargamos el curso con su jerarquía completa: Ciclo -> Semestre -> Año
        $cursos = Curso::with(['ciclo.semestre.anioAcademico', 'profesorJefe'])->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        // Solo necesitamos los años para iniciar la cadena de selección
        $anios = Anio_academico::where('activo', 1)->get();

       // $user = User::where('role', 'profesor')->get();
        $profesores = Profesor::all();

        return view('cursos.create', compact('anios', 'profesores'));
    }

    public function store(Request $request) {
        //dd($request->all());

        $request->validate(['nivel' => 'required', 'letra' => 'required']);
        Curso::create($request->all());
        return redirect()->route('cursos.index')->with('success', 'Curso creado.');
    }

    public function edit(Curso $curso) {
        $profesores = Profesor::all();
        $ciclos = Ciclo::all();
        return view('cursos.edit', compact('curso', 'profesores', 'ciclos'));
    }

    public function update(Request $request, Curso $curso) {
        $curso->update($request->all());
        return redirect()->route('cursos.index')->with('success', 'Curso actualizado.');
    }

    public function destroy(Curso $curso) {
        $curso->delete();
        return redirect()->route('cursos.index')->with('success', 'Curso eliminado.');
    }
}