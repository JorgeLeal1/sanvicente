<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profesor;
use App\Models\Direccion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProfesorController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->get('buscar');

        // Buscamos por nombre, apellido o rut usando una consulta con filtros
        $profesores = Profesor::when($buscar, function ($query, $buscar) {
                return $query->where(function($q) use ($buscar) {
                    $q->where('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%") 
                    ->orWhere('rut', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5); // Paginación de a 10

        return view('profesores.index', compact('profesores', 'buscar'));
    }

    public function create() {
        return view('profesores.create');
    }

    // En el método store (Lógica para Dirección):
    public function store(Request $request) {
        dd($request->all());

        $request->validate([
            'rut' => 'required|unique:profesores,rut',
            'nombres' => 'required',
            'apellidos' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8', // 'confirmed' busca automáticamente un campo llamado password_confirmation
            // Validaciones para dirección
            'calle' => 'required',
            'numero' => 'required|integer',
            'comuna' => 'required',
            'ciudad' => 'required',
            'region' => 'required',
        ]);

        // 1. Crear Dirección
        $direccion = Direccion::create($request->only(['calle', 'numero', 'comuna', 'ciudad', 'region']));

        // 2. Crear Usuario
        $user = User::create([
            'name' => $request->nombres . ' ' . $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Profesor',
        ]);

        // 3. Crear Profesor con direccion_id
        $profesor = Profesor::create(array_merge($request->all(), [
            'user_id' => $user->id,
            'direccion_id' => $direccion->id
        ]));

        //return redirect()->route('profesores.index')->with('success', 'Profesor creado con éxito');
    }
    public function edit(Profesor $profesore) { // Laravel usa el plural por defecto
        $profesor = $profesore;
        return view('profesores.edit', compact('profesor'));
    }

    public function update(Request $request, Profesor $profesore) {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'especialidad' => 'required',
        ]);

        $profesore->update($request->all());

        // DEVOLVER JSON PARA AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'profesor' => $profesore,
                'message' => 'Datos actualizados correctamente.'
            ]);
        }

        return redirect()->route('profesores.index')->with('success', 'Datos actualizados.');
    }

    //**** se debe modificar para que el profesor pase a un estado inactivo no eliminado */

    public function darDeBaja($id)
    {
        $profesor = Profesor::findOrFail($id);
        $nuevoEstado = $profesor->estado == 1 ? 0 : 1;
        $profesor->update(['estado' => $nuevoEstado]);

        // Sincronizar usuario
        $usuario = User::where('id', $profesor->user_id)->first();
        if ($usuario) {
            $usuario->update(['estado' => $nuevoEstado]);
        }

        // Retorno para AJAX
        return response()->json([
            'success' => true,
            'nuevoEstado' => $nuevoEstado,
            'message' => 'Estado actualizado correctamente'
        ]);
    }


    public function destroy(Profesor $profesore) {
        $profesore->delete();
        return redirect()->route('profesores.index')->with('success', 'Profesor eliminado.');
    }


    public function misCursos($anioAcademicoId)
{
    $profesor = auth::user()->profesor;

    $cursos = $profesor->cargasAcademicas()
        ->with(['curso', 'asignatura', 'curso.ciclo.semestre'])
        ->where('anio_academico_id', $anioAcademicoId)
        ->get()
        ->groupBy('curso_id');

    return view('profesor.cursos', compact('cursos'));
}



}