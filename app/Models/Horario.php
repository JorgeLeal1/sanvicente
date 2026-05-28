<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'aula',
        'carga_academica_id',
    ];

    public function cargaAcademica() {
        return $this->belongsTo(Carga_academica::class, 'carga_academica_id');
    }

}