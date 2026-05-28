<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $table = 'semestres';

    protected $fillable = [
        'anio_academico_id',
        'numero_semestre',
        'nombre',
        'fecha_inicio',
        'fecha_termino',
        'estado'
    ];

    protected $casts = [
        'fecha_inicio'  => 'date',
        'fecha_termino' => 'date',
        'estado'        => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function anioAcademico()
    {
        return $this->belongsTo(Anio_academico::class, 'anio_academico_id');
    }

    public function ciclos()
    {
        return $this->hasMany(Ciclo::class);
    }

    public function cursos()
    {
        return $this->hasManyThrough(Curso::class, Ciclo::class);
    }

    public function matriculas()
    {
        return $this->hasManyThrough(
            Matricula::class,
            Curso::class,
            'ciclo_id',     // FK en cursos
            'curso_id',     // FK en matriculas
            'id',           // Local key en semestres
            'id'            // Local key en cursos
        );
    }

    public function cargasAcademicas()
    {
        return $this->hasManyThrough(
            Carga_academica::class,
            Curso::class,
            'ciclo_id',
            'curso_id'
        );
    }
}
