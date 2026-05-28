<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colegio extends Model
{
        protected $fillable = [
        "nombre",
        "rbd",
        "estado", // 0 = Inactivo, 1 = Activo
        "direccion_id",
    ];

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

    public function aniosAcademicos()
    {
        return $this->hasMany(Anio_academico::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    public function semestres()
    {
        return $this->hasManyThrough(Semestre::class, Anio_academico::class);
    }

}
