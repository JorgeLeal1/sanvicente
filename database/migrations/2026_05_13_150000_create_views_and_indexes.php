<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ==================== ÍNDICES PARA MEJORAR RENDIMIENTO ====================

        Schema::table('alumnos', function ($table) {
            $table->index('persona_id');
            $table->index('user_id');
        });

        Schema::table('profesores', function ($table) {
            $table->index('persona_id');
            $table->index('user_id');
        });

        Schema::table('matriculas', function ($table) {
            $table->index('alumno_id');
            $table->index('curso_id');
            $table->index('anio_academico_id');
            $table->index(['alumno_id', 'anio_academico_id']);
        });

        Schema::table('carga_academicas', function ($table) {
            $table->index('profesor_id');
            $table->index('asignatura_id');
            $table->index('curso_id');
            $table->index('anio_academico_id');
            $table->index(['profesor_id', 'anio_academico_id']);
        });

        Schema::table('evaluaciones', function ($table) {
            $table->index('matricula_id');
            $table->index('carga_academica_id');
            $table->index('tipo_evaluacion_id');
            $table->index('user_id');
            $table->index(['matricula_id', 'carga_academica_id']);
        });

        Schema::table('asistencias', function ($table) {
            $table->index('matricula_id');
            $table->index('carga_academica_id');
            $table->index('fecha');
            $table->index('user_id');
        });
        /*
        Schema::table('alumno_apoderados', function ($table) {
            $table->index('alumno_id');
            $table->index('apoderado_id');
            $table->index('es_principal');
        });*/

        // ==================== VISTAS SQL ====================

        DB::statement("DROP VIEW IF EXISTS vista_alumnos_por_curso");
        DB::statement("
            CREATE VIEW vista_alumnos_por_curso AS
            SELECT 
                aa.anio_valor,
                c.nivel,
                c.letra,
                COUNT(DISTINCT m.alumno_id) as total_alumnos,
                COUNT(CASE WHEN p.genero = 'M' THEN 1 END) as total_hombres,
                COUNT(CASE WHEN p.genero = 'F' THEN 1 END) as total_mujeres,
                COUNT(DISTINCT pr.id) as total_profesores
            FROM matriculas m
            JOIN anio_academicos aa ON aa.id = m.anio_academico_id
            JOIN cursos c ON c.id = m.curso_id
            JOIN alumnos al ON al.id = m.alumno_id
            JOIN personas p ON p.id = al.persona_id
            LEFT JOIN carga_academicas ca ON ca.curso_id = c.id 
                AND ca.anio_academico_id = m.anio_academico_id
            LEFT JOIN profesores pr ON pr.id = ca.profesor_id
            GROUP BY aa.anio_valor, c.id, c.nivel, c.letra
            ORDER BY aa.anio_valor DESC, c.nivel, c.letra;
        ");

        DB::statement("DROP VIEW IF EXISTS vista_rendimiento_alumnos");
        DB::statement("
            CREATE VIEW vista_rendimiento_alumnos AS
            SELECT 
                p.rut,
                CONCAT(p.nombre1, ' ', COALESCE(p.nombre2, ''), ' ', p.apellido1, ' ', COALESCE(p.apellido2, '')) as nombre_completo,
                c.nivel,
                c.letra,
                a.nombre as asignatura,
                AVG(e.nota) as promedio,
                MIN(e.nota) as nota_min,
                MAX(e.nota) as nota_max,
                COUNT(e.id) as total_evaluaciones
            FROM evaluaciones e
            JOIN matriculas m ON m.id = e.matricula_id
            JOIN alumnos al ON al.id = m.alumno_id
            JOIN personas p ON p.id = al.persona_id
            JOIN cursos c ON c.id = m.curso_id
            JOIN carga_academicas ca ON ca.id = e.carga_academica_id
            JOIN asignaturas a ON a.id = ca.asignatura_id
            GROUP BY p.id, c.id, a.id;
        ");

        DB::statement("DROP VIEW IF EXISTS vista_carga_profesores");
        DB::statement("
            CREATE VIEW vista_carga_profesores AS
            SELECT 
                CONCAT(p.nombre1, ' ', p.apellido1) as profesor,
                a.nombre as asignatura,
                c.nivel,
                c.letra,
                COUNT(DISTINCT m.alumno_id) as total_alumnos,
                aa.anio_valor
            FROM carga_academicas ca
            JOIN profesores pr ON pr.id = ca.profesor_id
            JOIN personas p ON p.id = pr.persona_id
            JOIN asignaturas a ON a.id = ca.asignatura_id
            JOIN cursos c ON c.id = ca.curso_id
            JOIN anio_academicos aa ON aa.id = ca.anio_academico_id
            LEFT JOIN matriculas m ON m.curso_id = c.id AND m.anio_academico_id = ca.anio_academico_id
            GROUP BY pr.id, a.id, c.id, aa.anio_valor;
        ");

        DB::statement("DROP VIEW IF EXISTS vista_asistencia");
        DB::statement("
            CREATE VIEW vista_asistencia AS
            SELECT 
                p.rut,
                CONCAT(p.nombre1, ' ', p.apellido1) as alumno,
                a.nombre as asignatura,
                COUNT(*) as total_clases,
                SUM(CASE WHEN ast.estado = 1 THEN 1 ELSE 0 END) as presentes,
                ROUND(AVG(CASE WHEN ast.estado = 1 THEN 100.0 ELSE 0 END), 2) as porcentaje_asistencia
            FROM asistencias ast
            JOIN matriculas m ON m.id = ast.matricula_id
            JOIN alumnos al ON al.id = m.alumno_id
            JOIN personas p ON p.id = al.persona_id
            JOIN carga_academicas ca ON ca.id = ast.carga_academica_id
            JOIN asignaturas a ON a.id = ca.asignatura_id
            GROUP BY p.id, a.id;
        ");

       // $this->command->info('✅ Vistas e índices creados correctamente.');
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vista_alumnos_por_curso');
        DB::statement('DROP VIEW IF EXISTS vista_rendimiento_alumnos');
        DB::statement('DROP VIEW IF EXISTS vista_carga_profesores');
        DB::statement('DROP VIEW IF EXISTS vista_asistencia');

        // Aquí podrías eliminar índices si es necesario, pero normalmente no se hace
    }
};