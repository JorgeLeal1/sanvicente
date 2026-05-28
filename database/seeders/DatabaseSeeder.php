<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Anio_academico;
use App\Models\Semestre;
use App\Models\Ciclo;
use App\Models\Curso;
use App\Models\Asignatura;
use App\Models\Profesor;
use App\Models\Matricula;
use App\Models\Colegio;
use App\Models\Tipo_evaluacion;
use App\Models\Alumno;
use App\Models\Carga_academica;
use App\Models\Evaluacion;
use App\Models\Apoderado;
use App\Models\Persona;
use App\Models\Direccion;

use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        // ==================== DIRECCIÓN ====================
        $direccion = Direccion::create([
            'calle' => 'Av. Principal',
            'numero' => '123',
            'comuna' => 'Santiago',
            'ciudad' => 'Santiago',
            'region' => 'Metropolitana'
        ]);

        // ==================== USUARIOS ====================

        // administrador
        $usuario =User::create([
            'name' => 'Jorge Leal',
            'email' => 'jorge.leal@talcahuanoeduca.cl',
            'role' => 'admin',
            'password'=> Hash::make('123456789'),
        ]);

        // Crear usuarios de prueba
        $usuario1 =User::create([
            'name' => 'Juan Carlos',
            'email' => 'Juan@colegiosanvicente.cl',
            'role' => 'profesor',
            'password'=> Hash::make('123456789'),
        ]);

        $usuario2 =User::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@colegiosanvicente.cl',
            'role' => 'profesor',
            'password'=> Hash::make('123456789'),
        ]);

        // ==================== PERSONAS ====================
        $personaProfesor = Persona::create([
            'rut' => '12.345.678-9',
            'nombre1' => 'Juan',
            'nombre2' => 'Carlos',
            'apellido1' => 'Pérez',
            'apellido2' => 'López',
            'edad' => 40,
            'fecha_nacimiento' => '1985-06-15',
            'genero' => 'M',
            'telefono' => '987654321',
            'email' => 'juan.perez@sanvicente.cl',
            'direccion_id' => $direccion->id,
        ]);

        $personaProfesor1 = Persona::create([
            'rut' => '12.345.678-8',
            'nombre1' => 'María',
            'nombre2' => 'González',
            'apellido1' => 'Sánchez',
            'apellido2' => 'López',
            'edad' => 38,
            'fecha_nacimiento' => '1985-06-15',
            'genero' => 'F',
            'telefono' => '987654321',
            'email' => 'maria.gonzalez@sanvicente.cl',
            'direccion_id' => $direccion->id,
        ]);

        // ==================== PROFESORES ====================
        $profesor = Profesor::create([
            'especialidad' => 'Matemáticas',
            'persona_id' => $personaProfesor->id,
            'user_id' => $usuario1->id,

        ]);

        $profesor2 = Profesor::create([
            'especialidad' => 'Relogion',
            'persona_id' => $personaProfesor1->id,
            'user_id' => $usuario2->id,

        ]);


       // ==================== COLEGIO ====================
        $colegio = Colegio::create([
            'nombre' => 'Colegio San Vicente',
            'rbd' => '12345',
            'estado' => 1,
            'direccion_id' => $direccion->id,
        ]);

        // ==================== AÑO ACADÉMICO ====================
        $anio = Anio_academico::create([
            'colegio_id' => $colegio->id,
            'anio_valor' => 2026,
            'estado' => 1,
            'fecha_inicio' => '2026-03-01',
            'fecha_termino' => '2026-12-15'
        ]);

        // ==================== 3. SEMESTRES ====================
        $semestre1 = Semestre::create([
            'anio_academico_id' => $anio->id,
            'numero_semestre' => 1,
            'nombre' => 'Primer Semestre',
            'fecha_inicio' => '2026-03-01',
            'fecha_termino' => '2026-07-15',
            'estado' => 1
        ]);

        // ==================== CICLO Y CURSO ====================
        $ciclo = Ciclo::create([
            'semestre_id' => $semestre1->id,
            'nombre' => 'Básica',
            'estado' => 1
        ]);

        $curso = Curso::create([
            'ciclo_id' => $ciclo->id,
            'nivel' => '1° Medio',
            'letra' => 'A',
            'estado' => 1,
            'profesor_jefe_id' => $profesor->id
        ]);

       // ==================== ASIGNATURA Y TIPOS DE EVALUACIÓN ====================
        $matematicas = Asignatura::create([
            'colegio_id' => $colegio->id,
            'codigo' => 101,
            'nombre' => 'Matemáticas',
            'descripcion' => 'Matemáticas 1° Medio',
            'estado' => 1
        ]);

        // Tipos de Evaluación para Matemáticas
        /* $tipo_evaluacion = Tipo_evaluacion::create([
            'asignatura_id' => $matematicas->id,
            'nombre' => 'N1',
            'codigo' => 'N1',
            'orden' => 1
        ]);*/

        Tipo_evaluacion::insert([
            ['asignatura_id' => $matematicas->id, 'nombre' => 'N1', 'codigo' => 'N1', 'orden' => 1, 'estado' => 1],
            ['asignatura_id' => $matematicas->id, 'nombre' => 'N2', 'codigo' => 'N2', 'orden' => 2, 'estado' => 1],
            ['asignatura_id' => $matematicas->id, 'nombre' => 'Examen Final', 'codigo' => 'FINAL', 'orden' => 3, 'estado' => 1],
        ]);


        // ==================== 7. CARGA ACADÉMICA, MATRÍCULA ALUMNO ====================
        // Apoderado (Padre)
        $personaApoderadoPadre = Persona::create([
            'rut' => '19.876.543-1',
            'nombre1' => 'Carlos',
            'nombre2' => 'Alberto',
            'apellido1' => 'González',
            'apellido2' => 'Sánchez',
            'edad' => 48,
            'fecha_nacimiento' => '1975-04-20',
            'genero' => 'M',
            'telefono' => '912345678',
            'email' => 'carlos.gonzalez@email.com',
            'direccion_id' => $direccion->id,
        ]);

        // Apoderado (Madre)
        $personaApoderadoMadre = Persona::create([
            'rut' => '11.223.344-5',
            'nombre1' => 'Ana',
            'nombre2' => 'María',
            'apellido1' => 'Silva',
            'apellido2' => 'Rojas',
            'edad' => 45,
            'fecha_nacimiento' => '1988-03-20',
            'genero' => 'F',
            'telefono' => '998877665',
            'email' => 'ana.silva@email.com',
            'direccion_id' => $direccion->id,
        ]);

        $apoderadoPadre = Apoderado::create([
            'persona_id' => $personaApoderadoPadre->id,
            'relacion' => 'Padre',
            'estado' => 1,
        ]);

        $apoderadoMadre = Apoderado::create([
            'persona_id' => $personaApoderadoMadre->id,
            'relacion' => 'Madre',
            'estado' => 1,
        ]);

        // Alumno
        $personaAlumno = Persona::create([
            'rut' => '19.876.543-2',
            'nombre1' => 'María',
            'nombre2' => 'José',
            'apellido1' => 'González',
            'apellido2' => 'Silva',
            'edad' => 15,
            'fecha_nacimiento' => '2011-05-10',
            'genero' => 'F',
            'telefono' => '912345678',
            'email' => 'maria.gonzalez@email.com',
            'direccion_id' => $direccion->id,
        ]);

        $personaAlumno2 = Persona::create([
            'rut' => '19.876.543-3',
            'nombre1' => 'Pedro',
            'nombre2' => 'Pablo',
            'apellido1' => 'González',
            'apellido2' => 'Silva',
            'edad' => 14,
            'fecha_nacimiento' => '2011-05-10',
            'genero' => 'M',
            'telefono' => '912345678',
            'email' => 'pedro.gonzalez@email.com',
            'direccion_id' => $direccion->id,
        ]);

        $alumno = Alumno::create([
            'persona_id' => $personaAlumno->id,
            'user_id' => null, // No tiene usuario en este ejemplo
        ]);

        $alumno2 = Alumno::create([
            'persona_id' => $personaAlumno2->id,
            'user_id' => null, // No tiene usuario en este ejemplo
        ]);


        // Relación Muchos a Muchos con Apoderados
        $alumno->apoderados()->attach($apoderadoPadre->id, ['es_principal' => true]);
        $alumno->apoderados()->attach($apoderadoMadre->id, ['es_principal' => false]);

        //Hermanos
        $alumno2->apoderados()->attach($apoderadoPadre->id, ['es_principal' => false]);
        $alumno2->apoderados()->attach($apoderadoMadre->id, ['es_principal' => true]);


        // ==================== CARGA ACADÉMICA, MATRÍCULA ALUMNO ====================

        $carga = Carga_academica::create([
            'profesor_id' => $profesor->id,
            'asignatura_id' => $matematicas->id,
            'curso_id' => $curso->id,
            'anio_academico_id' => $anio->id
        ]);

        $matricula1 = Matricula::create([
            'alumno_id' => $alumno->id,
            'curso_id' => $curso->id,
            'anio_academico_id' => $anio->id,
            'semestre_id' => $semestre1->id
        ]);


        $matricula2 = Matricula::create([
            'alumno_id' => $alumno2->id,
            'curso_id' => $curso->id,
            'anio_academico_id' => $anio->id,
            'semestre_id' => $semestre1->id
        ]);

        // 8. Evaluaciones de prueba
        Evaluacion::create([
            'matricula_id' => $matricula1->id,
            'carga_academica_id' => $carga->id,
            'tipo_evaluacion_id' => 1, // N1
            'nota' => 6.5,
            'fecha' => now(),
            'user_id' => $usuario->id
        ]);

        Evaluacion::create([
            'matricula_id' => $matricula2->id,
            'carga_academica_id' => $carga->id,
            'tipo_evaluacion_id' => 1, // N1
            'nota' => 7.0,
            'fecha' => now(),
            'user_id' => $usuario->id
        ]);

        $this->command->info('✅ Seeder completado exitosamente con datos de prueba');
        $this->command->info('   Usuarios creados 3');
        $this->command->info("   Alumnos creados: 2");
        $this->command->info("   Apoderados por alumno: 2");

    }
}
