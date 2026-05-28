<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anio_academico extends Model
{
    protected $table = "anio_academicos";
     protected $fillable = [
          'anio_valor', 
          'estado', // 0 = Inactivo, 1 = Activo
          'fecha_inicio',
          'fecha_termino',
          'colegio_id',
          ];

          protected $casts = [
            'fecha_inicio' => 'date',
            'fecha_termino' => 'date',
        ];

     public function colegio()
     {
          return $this->belongsTo(Colegio::class, 'colegio_id');
     }

     public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

    public function cargasAcademicas()
    {
        return $this->hasMany(Carga_academica::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
