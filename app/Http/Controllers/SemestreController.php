<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Models\Anio_academico;
use App\Actions\ClonarSemestreAction;
use Illuminate\Http\Request;

class SemestreController extends Controller
{
    protected $clonarAction;

    public function __construct(ClonarSemestreAction $clonarAction)
    {
        $this->clonarAction = $clonarAction;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eloquent carga automáticamente las relaciones anioAcademico, ciclos y cursos para evitar N+1
        $semestres = Semestre::with(['anioAcademico', 'ciclos.cursos'])
                        ->orderBy('anio_academico_id', 'desc')
                        ->orderBy('numero_semestre', 'desc')
                        ->paginate(15);

        /*
        ======= Consulta en SQL para entender lo que hace Eloquent =======
        SELECT
            s.*,
            aa.anio_valor,
            c.id as ciclo_id,
            c.nombre as ciclo_nombre,
            cu.id as curso_id,
            cu.nivel,
            cu.letra
        FROM semestres s
        LEFT JOIN anio_academicos aa ON aa.id = s.anio_academico_id
        LEFT JOIN ciclos c ON c.semestre_id = s.id
        LEFT JOIN cursos cu ON cu.ciclo_id = c.id
        ORDER BY s.anio_academico_id DESC, s.numero_semestre DESC
        LIMIT 15 OFFSET 0;
        */



       //$anios = Anio_academico::orderBy('anio_valor', 'desc')->get();

        //return view('semestres.index', compact('semestres', 'anios'));
        return view('semestres.index', compact('semestres'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $anioActual = Anio_academico::where('estado', true)
                    ->latest('anio_valor')
                    ->first();

    // Obtenemos todos los años para el select
    $anios = Anio_academico::orderBy('anio_valor', 'desc')->get();

    $ultimoSemestre = Semestre::with('anioAcademico')
                        ->latest()
                        ->first();

    /*
    ======= Consulta en SQL para entender lo que hace Eloquent =======
    SELECT
        s.*,
        aa.anio_valor,
        aa.fecha_inicio as anio_fecha_inicio,
        aa.fecha_termino as anio_fecha_termino
    FROM semestres s
    LEFT JOIN anio_academicos aa ON aa.id = s.anio_academico_id
    ORDER BY s.created_at DESC
    LIMIT 1;
    */



    return view('semestres.create', compact('anioActual', 'anios', 'ultimoSemestre'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    //dd($request->all());
        $request->validate([
            'anio_academico_id' => 'required|exists:anio_academicos,id',
            'numero_semestre'   => 'required|integer|min:1|max:4',
            'nombre'            => 'required|string|max:100',
            'fecha_inicio'      => 'required|date',
            'fecha_termino'     => 'required|date|after:fecha_inicio',
            'clonar_desde'      => 'nullable|exists:semestres,id',
        ]);

        // Si el usuario quiere clonar desde un semestre anterior
        if ($request->filled('clonar_desde') && $request->clonar_desde != '') {
        $semestreAnterior = Semestre::with([
                'ciclos.cursos.cargasAcademicas',
                'matriculas'
            ])->findOrFail($request->clonar_desde);

            try {
                $this->clonarAction->execute($semestreAnterior, [
                    'anio_academico_id' => $request->anio_academico_id,
                    'numero_semestre'   => $request->numero_semestre,
                    'nombre'            => $request->nombre,
                    'fecha_inicio'      => $request->fecha_inicio,
                    'fecha_termino'     => $request->fecha_termino,
                ]);


                return redirect()
                    ->route('semestres.index')
                    ->with('success', 'Semestre creado y estructura clonada correctamente.');

            } catch (\Exception $e) {
                return redirect()
                    ->back()
                    ->with('error', 'Error al clonar el semestre: ' . $e->getMessage());
            }
        }else {
            // Crear semestre sin clonar
            Semestre::create([
                'anio_academico_id' => $request->anio_academico_id,
                'numero_semestre'   => $request->numero_semestre,
                'nombre'            => $request->nombre,
                'fecha_inicio'      => $request->fecha_inicio,
                'fecha_termino'     => $request->fecha_termino,
                'estado'            => true,
            ]);

        }

       /* return redirect()
            ->route('semestres.index')
            ->with('success', 'Semestre creado correctamente.');*/
    }

    /**
     * Display the specified resource.
     */
    public function show(Semestre $semestre)
    {
        $semestre->load([
            'anioAcademico',
            'ciclos.cursos',                    // Ciclos y cursos
            'ciclos.cursos.profesorJefe.persona', // Profesor jefe
            'matriculas'                        // ***** Muy importante *****
        ]);

        return view('semestres.show', compact('semestre'));
    }
}
