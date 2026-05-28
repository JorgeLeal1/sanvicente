<?php

namespace App\Actions;

use App\Models\Semestre;
use Illuminate\Support\Facades\DB;

class ClonarSemestreAction
{
    public function execute(Semestre $semestreAnterior, array $data): Semestre
    {
        DB::beginTransaction();

        try {
            // Crear nuevo semestre
            $nuevoSemestre = Semestre::create([
                'anio_academico_id' => $data['anio_academico_id'],
                'numero_semestre'   => $data['numero_semestre'],
                'nombre'            => $data['nombre'],
                'fecha_inicio'      => $data['fecha_inicio'],
                'fecha_termino'     => $data['fecha_termino'],
                'estado'            => true,
            ]);

            // ==================== CLONAR TODO CON JOINs ====================

            // 1. Clonar Ciclos
            $ciclos = DB::table('ciclos')
                        ->where('semestre_id', $semestreAnterior->id)
                        ->get();

            foreach ($ciclos as $ciclo) {
                $nuevoCicloId = DB::table('ciclos')->insertGetId([
                    'nombre'       => $ciclo->nombre,
                    'estado'       => $ciclo->estado,
                    'semestre_id'  => $nuevoSemestre->id,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);

                // 2. Clonar Cursos de este ciclo
                $cursos = DB::table('cursos')
                            ->where('ciclo_id', $ciclo->id)
                            ->get();

                foreach ($cursos as $curso) {
                    $nuevoCursoId = DB::table('cursos')->insertGetId([
                        'nivel'             => $curso->nivel,
                        'letra'             => $curso->letra,
                        'estado'            => $curso->estado,
                        'ciclo_id'          => $nuevoCicloId,
                        'profesor_jefe_id'  => $curso->profesor_jefe_id, // se puede cambiar después
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ]);

                    // 3. Clonar Cargas Académicas (Asignaturas)
                    $cargas = DB::table('carga_academicas')
                                ->where('curso_id', $curso->id)
                                ->get();

                    foreach ($cargas as $carga) {
                        DB::table('carga_academicas')->insert([
                            'profesor_id'       => $carga->profesor_id,
                            'asignatura_id'     => $carga->asignatura_id,
                            'curso_id'          => $nuevoCursoId,
                            'anio_academico_id' => $nuevoSemestre->anio_academico_id,
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);
                    }
                }
            }

            // 4. Clonar Matrículas
            $matriculas = DB::table('matriculas')
                            ->whereIn('curso_id',
                                DB::table('cursos')
                                    ->whereIn('ciclo_id',
                                        DB::table('ciclos')
                                            ->select('id')
                                            ->where('semestre_id', $semestreAnterior->id)
                                    )
                                    ->select('id')
                            )
                            ->get();

            foreach ($matriculas as $mat) {
                DB::table('matriculas')->insert([
                    'alumno_id'         => $mat->alumno_id,
                    'curso_id'          => $mat->curso_id, // Se puede ajustar si cambian de curso
                    'anio_academico_id' => $nuevoSemestre->anio_academico_id,
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }

            DB::commit();

            return $nuevoSemestre;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
