<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = "matriculas";
    protected $fillable = [

        'num_sigue',
        'num_matricula',
        'num_pago_cgp',
        'fecha_matricula',
        'fecha_retiro', //nulo para el retiro del curso, si es que se retira
        'estado_matricula',
        'observaciones',
        
        'alumno_id',
        'curso_id',
        'anio_academico_id',
        'semestre_id',
        'entrevistador_id',//usuario que realizó la matrícula

    ];

    // Relación con el alumno
    public function alumno() {
        return $this->belongsTo(Alumno::class, 'alumno_id');
    }

    // Relación con el Curso
    public function curso() {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    // Relación con el Anios_academicos
    public function anioAcademico() {
        return $this->belongsTo(Anio_academico::class, 'anio_academico_id');
    }

    public function semestre() {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }

    public function entrevistador() {
        return $this->belongsTo(User::class, 'entrevistador_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function promediosSemestre()
    {
        return $this->hasMany(Promedio_semestre::class);
    }
}
