<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Alumno extends Model
{
    protected $table = "alumnos";
    protected $fillable = [
        'pueblo_originario', // Nuevo campo para indicar el pueblo originario del alumno, string
        'pertenece_etnia', // Nuevo campo para indicar si el alumno pertenece a una etnia específica, booleano (true/false)
        'cursos_repetidos',
        'motivo',
        'estado',
        'persona_id', 
        'user_id'

    ];

    public function persona() {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Relación con el Usuario (Para el login)
    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // === Relación Muchos a Muchos con Apoderados ===
    public function apoderados()
    {
        return $this->belongsToMany(Apoderado::class, 'alumno_apoderados')
                    ->withPivot('es_principal')
                    ->withTimestamps();
    }

    public function apoderadoPrincipal()
    {
        return $this->apoderados()
                    ->where('es_principal', true)
                    ->first();
    }              

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function matriculaDelAnio(int $anioAcademicoId)
    {
        return $this->matriculas()
                    ->where('anio_academico_id', $anioAcademicoId)
                    ->first();
    }

}