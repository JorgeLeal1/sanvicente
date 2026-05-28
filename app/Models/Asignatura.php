<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
     protected $fillable = [
         "codigo",
         "nombre",
         "descripcion",
         "estado", // 0 = Inactivo, 1 = Activo
         "colegio_id", // Relación con tabla colegios
      ];


     public function colegio()
     {
         return $this->belongsTo(Colegio::class, 'colegio_id');
     }
public function tiposEvaluacion()
    {
        return $this->hasMany(Tipo_evaluacion::class);
    }

    public function cargasAcademicas()
    {
        return $this->hasMany(Carga_academica::class);
    }
}
