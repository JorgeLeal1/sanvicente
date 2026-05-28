<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    protected $fillable = [
        'relacion',// Relación del apoderado con el alumno, por ejemplo: "Padre", "Madre", "Tío", etc. Se podría implementar como un enum o una tabla de relaciones si se requiere una gestión más robusta de las relaciones en el sistema, pero se deja como un campo adicional para mayor flexibilidad en caso de que se requieran relaciones adicionales en el futuro.
        'Escolaridad',
        'Profesion_oficio',
        'tipo_trabajo',
        'Ocupacion_actual',
        'Num_hijos',
        'vive_con_estudiante', // es boolean Si o no 
        'desc_motivo', // Motivo por el cual Si/No vive con estudiante, separacion etc
        'estado',
        'desc_estado', // se puede dar debaja un apoderado en caso extremo por fallecimiento, teniendo la descripcion de lo que paso
        'persona_id',

    ];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // === Relación Muchos a Muchos con Alumnos ===
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumno_apoderado')
                    ->withPivot('es_principal')
                    ->withTimestamps();
    }


    public function alumnosPrincipales()
    {
        return $this->alumnos()->wherePivot('es_principal', true);
    }


}