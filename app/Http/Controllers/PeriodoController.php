<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anio_academico;
use App\Models\Semestre;
use App\Models\Ciclo;

class PeriodoController extends Controller
{
public function showSelector()
{
// Solo traemos los años donde activo sea 1
    $anios = Anio_academico::where('estado', 1)
                ->with('semestres')
                ->get();
    

    // Por esto (Carga anidada):
    //$anios = Anios_academico::where('activo', 1)->with('semestres.ciclos')->get();

    return view('auth.select-period', compact('anios'));
}

    public function store(Request $request)
    {

       // dd($request->all());
        $request->validate([
            'anio_id' => 'required',
            'semestre_id' => 'required',
            'ciclo_id' => 'required',
        ]);

        // Guardamos los IDs y nombres en la sesión para usarlos en la barra superior
        $anio = Anio_academico::find($request->anio_id);
        $semestre = Semestre::find($request->semestre_id);
        $ciclo = Ciclo::find($request->ciclo_id);

        //dd($anio, $semestre, $ciclo);
       
        session([
            'periodo_anio_id' => $anio->id,
            'periodo_anio_valor' => $anio->anio_valor,
            'periodo_semestre_id' => $semestre->numero_semestre,
            'periodo_semestre_nombre' => $semestre->nombre,
            'periodo_ciclo_id' => $ciclo->id,
            'periodo_ciclo_nombre' => $ciclo->nombre,
        ]);

        return redirect()->route('dashboard');
    }

    // Método para obtener semestres
    // Obtener semestres que pertenecen al año elegido
        public function getSemestres($anio_id) {
            $semestres = Semestre::where('anios_academicos_id', $anio_id)->get();
            return response()->json($semestres);
        }

        // Obtener ciclos que pertenecen al semestre elegido
        public function getCiclos($semestre_id) {
            $ciclos = Ciclo::where('semestre_id', $semestre_id)->get();
            return response()->json($ciclos);
        }


}