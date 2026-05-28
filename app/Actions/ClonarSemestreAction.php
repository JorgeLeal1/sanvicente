<?php

namespace App\Actions;

use App\Models\Semestre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClonarSemestreAction
{
    public function execute(Semestre $semestreAnterior, array $data): Semestre
    {
        DB::beginTransaction();

        try {
            Log::info('Iniciando clonado de semestre', ['semestre_id' => $semestreAnterior->id]);

            // Cargar relaciones
            $semestreAnterior->load([
                'ciclos.cursos.cargasAcademicas',
                'ciclos.cursos'
            ]);

            Log::info('Relaciones cargadas', [
                'ciclos' => $semestreAnterior->ciclos->count(),
                'cursos_total' => $semestreAnterior->ciclos->sum(fn($c) => $c->cursos->count())
            ]);

            // Crear nuevo semestre
            $nuevoSemestre = Semestre::create([
                'anio_academico_id' => $data['anio_academico_id'],
                'numero_semestre'   => $data['numero_semestre'],
                'nombre'            => $data['nombre'],
                'fecha_inicio'      => $data['fecha_inicio'],
                'fecha_termino'     => $data['fecha_termino'],
                'estado'            => true,
            ]);

            Log::info('Nuevo semestre creado', ['id' => $nuevoSemestre->id]);

            $totalClonados = 0;

            // Clonar Ciclos, Cursos y Cargas_Académicas
            foreach ($semestreAnterior->ciclos as $cicloAnt) {
                $nuevoCiclo = $cicloAnt->replicate();
                $nuevoCiclo->semestre_id = $nuevoSemestre->id;
                $nuevoCiclo->save();

                foreach ($cicloAnt->cursos as $cursoAnt) {
                    $nuevoCurso = $cursoAnt->replicate(['profesor_jefe_id']);

                    // Si el curso original tenía profesor jefe, lo copiamos
                    if ($cursoAnt->profesor_jefe_id) {
                        $nuevoCurso->profesor_jefe_id = $cursoAnt->profesor_jefe_id;
                    } else {
                        $nuevoCurso->profesor_jefe_id = null; // o asignar uno por defecto
                    }

                    $nuevoCurso->ciclo_id = $nuevoCiclo->id;
                    $nuevoCurso->save();

                    // Clonar Cargas_Académicas
                    foreach ($cursoAnt->cargasAcademicas as $cargaAnt) {
                        $nuevaCarga = $cargaAnt->replicate();
                        $nuevaCarga->curso_id = $nuevoCurso->id;
                        $nuevaCarga->anio_academico_id = $nuevoSemestre->anio_academico_id;
                        $nuevaCarga->save();
                    }
                }
            }

            // ==================== PROMOVER ALUMNOS ====================
            foreach ($semestreAnterior->matriculas as $matriculaAnt) {
                // Crear nueva matrícula en el nuevo semestre
                $nuevaMatricula = $matriculaAnt->replicate([
                    'created_at',
                    'updated_at'
                ]);

                $nuevaMatricula->anio_academico_id = $nuevoSemestre->anio_academico_id;
                $nuevaMatricula->semestre_id = $nuevoSemestre->id;
                $nuevaMatricula->save();
            }




            Log::info('Clonado finalizado', ['total_cargas_clonadas' => $totalClonados]);

            DB::commit();

            Log::info('Commit exitoso');

            return $nuevoSemestre;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al clonar semestre', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
