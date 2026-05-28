<?php
namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    public function index() {
        $alumnos = Alumno::with('curso')->get();
        return view('alumnos.index', compact('alumnos'));
    }

    public function create() {
        $cursos = Curso::all();
        return view('alumnos.create', compact('cursos'));
    }

    public function store(Request $request) {
        $request->validate(['rut' => 'required|unique:alumnos', 'nombre' => 'required']);
        Alumno::create($request->all());
        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado.');
    }

    public function edit(Alumno $alumno) {
        $cursos = Curso::all();
        return view('alumnos.edit', compact('alumno', 'cursos'));
    }

    public function update(Request $request, Alumno $alumno) {
        $alumno->update($request->all());
        return redirect()->route('alumnos.index')->with('success', 'Datos actualizados.');
    }

    public function destroy(Alumno $alumno) {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado.');
    }
}