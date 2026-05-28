<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'fecha',
        'estado',
        'observacion',
        'matricula_id',
        'carga_academica_id',
        'user_id',
    ];

    // Relación con el Usuario (Para el login)
    public function matricula() {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function cargaAcademica() {
        return $this->belongsTo(Carga_academica::class, 'carga_academica_id');
    }
    
    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }
}