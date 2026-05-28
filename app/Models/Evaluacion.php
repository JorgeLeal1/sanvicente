<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = "evaluaciones";
    protected $fillable = [
        'nota', // n1, n2, n3, n4, n5, n6, n7, n8, n9, n10 ,etc. dependiendo de la cantidad de evaluaciones que se quieran registrar
        'fecha', 
        'matricula_id', 
        'carga_academica_id',
        'tipo_evaluacion_id', // para saber si es parcial, final, etc.
        'user_id', // registra el usuario que hizo la nota
    ];

    public function matricula() {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function cargaAcademica() {
        return $this->belongsTo(Carga_academica::class, 'carga_academica_id');
    }

    public function tipoEvaluacion() {
        return $this->belongsTo(Tipo_evaluacion::class, 'tipo_evaluacion_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}