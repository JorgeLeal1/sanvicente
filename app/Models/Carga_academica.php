<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carga_academica extends Model
{
    protected $table = "carga_academicas";
    protected $fillable = [
        'profesor_id', 
        'asignatura_id', 
        'curso_id',
        'anio_academico_id'
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function anioAcademico()
    {
        return $this->belongsTo(Anio_academico::class);
    }

    public function matriculas()
    {
        return $this->hasManyThrough(Matricula::class, Curso::class, 'id', 'curso_id');
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function evaluacionesDelSemestre(int $semestreId)
    {
        return $this->evaluaciones()
                    ->whereHas('matricula', function($q) use ($semestreId) {
                        $q->where('semestre_id', $semestreId); // si agregas este campo
                    });
    }
}
