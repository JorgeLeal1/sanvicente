<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = [
        'nivel', 
        'letra', 
        'estado', // 0=inactivo, 1=activo
        'ciclo_id', 
        'profesor_jefe_id'
    ];

    // Relación con el Profesor Jefe
    public function profesorJefe() {
        return $this->belongsTo(Profesor::class, 'profesor_jefe_id');
    }

    // Relación con el Ciclo (Básica/Media)
    public function ciclo() {
        // El segundo parámetro es el nombre real de tu columna en la DB
        return $this->belongsTo(Ciclo::class, 'ciclo_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function cargasAcademicas()
    {
        return $this->hasMany(Carga_academica::class);
    }

    public function alumnos()
    {
        return $this->hasManyThrough(Alumno::class, Matricula::class);
    }    
}