<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promedio_semestre extends Model
{
    protected $table = 'promedio_semestres';
     protected $fillable = [
        'promedio',
        'total_evaluaciones',
        'promedio_final_anual',
        'semestre_id',
        'matricula_id',
        'carga_academica_id',

    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function cargaAcademica()
    {
        return $this->belongsTo(Carga_academica::class);
    }

}

