<?php

namespace App\Http\Controllers;

use App\Models\Anio_academico; // Ajusta según tu nombre real
use Illuminate\Http\Request;

class AnioController extends Controller
{
    public function create(Request $request)
    {

        // 1. Obtener el término de búsqueda
        $buscar = $request->get('buscar');

        // 2. Consultar los años con filtro y paginación
        $aniosRegistrados = Anio_academico::when($buscar, function ($query, $buscar) {
            return $query->where('anio_valor', 'like', "%{$buscar}%");
        })->with('semestres')
        ->orderBy('anio_valor', 'desc')
        ->paginate(2); // Mostramos 10 por página


        $anioActual = date('Y');
        $aniosDisponibles = $aniosDisponibles = range($anioActual, $anioActual + 5);

        // Traemos los años con sus semestres para mostrarlos en la tabla
        //$aniosRegistrados = Anio_academico::with('semestres')->orderBy('anio_valor', 'desc')->get();
        return view('anios.create', compact('aniosDisponibles', 'aniosRegistrados', 'buscar'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'anio_valor' => 'required|numeric|unique:anios_academicos,anio_valor',
            'semestres' => 'required|array|min:1',
        ]);

        $anio = Anio_academico::create(['anio_valor' => $request->anio_valor, 'activo' => 1]);

        foreach ($request->semestres as $index => $data) {
            $anio->semestres()->create([
                'numero_semestre' => $index + 1,
                'nombre' => $data['nombre']
            ]);
        }

        try {
            $anio->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al guardar el año académico: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Año y semestres creados con éxito.');
    }

    public function destroy($id)
    {
        try {
            $anio = Anio_academico::findOrFail($id);
            $anio->delete();

            return redirect()->back()->with('success', 'Año académico y sus semestres eliminados correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo eliminar el año. Es posible que tenga datos vinculados (alumnos o notas).');
        }
    }
    public function toggleStatus($id)
    {
        $anio = Anio_academico::findOrFail($id);
        
        // Cambia de 1 a 0 o de 0 a 1
        $anio->activo = !$anio->activo;
        $anio->save();

        $estado = $anio->activo ? 'activado' : 'desactivado';
        return redirect()->back()->with('success', "El año académico $anio->anio ha sido $estado.");
    }

}