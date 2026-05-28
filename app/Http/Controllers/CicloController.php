<?php
namespace App\Http\Controllers;

use App\Models\Ciclo;
use App\Models\Anio_academico;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CicloController extends Controller
{

    public function index(Request $request)
    {
        $buscarAnio = $request->get('buscar_anio');

        /*
            select * from `ciclos` where exists (
                select * from `semestres` where `ciclos`.`semestre_id` = `semestres`.`id` and exists
                    (
                    select * from `anios_academicos` where `semestres`.`anios_academicos_id` = `anios_academicos`.`id` and `anio` like ?
                    )
            )

        */
            
        // Cargamos la jerarquía completa para evitar el error N+1
        $query = Ciclo::with(['semestre.anioAcademico']);

        // Filtro de búsqueda para el Administrador
        if (auth::user()->role === 'admin' && $buscarAnio) {
            $query->whereHas('semestre.anioAcademico', function($q) use ($buscarAnio) {
                // Buscamos en la tabla de años académicos por la columna 'anio'
                $q->where('anio_valor', 'like', "%{$buscarAnio}%");
            });
        }elseif (auth::user()->role === 'profesor') {
            // Filtro por sesión para el profesor
            $query->where('semestre_id', session('periodo_semestre_id'));
        }
 // echo $query->toSql(); // Para depuración, muestra la consulta SQL generada
        $ciclos = $query->paginate(10);

        return view('ciclos.index', compact('ciclos', 'buscarAnio'));
    }

    public function create()
    {
        // Obtenemos los años activos
        $anios = Anio_academico::where('activo', 1)->get();
        return view('ciclos.create', compact('anios'));
    }

    public function store(Request $request) {
        $request->validate(['nombre' => 'required|max:50']);
        Ciclo::create($request->all());
        return redirect()->route('ciclos.index')->with('success', 'Ciclo creado con éxito.');
    }

    public function edit(Ciclo $ciclo) {
        return view('ciclos.edit', compact('ciclo'));
    }

    public function update(Request $request, Ciclo $ciclo) {
        $request->validate(['nombre' => 'required|max:50']);
        $ciclo->update($request->all());
        return redirect()->route('ciclos.index')->with('success', 'Ciclo actualizado.');
    }

    public function destroy(Ciclo $ciclo) {
        $ciclo->delete();
        return redirect()->route('ciclos.index')->with('success', 'Ciclo eliminado.');
    }
}