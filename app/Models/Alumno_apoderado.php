<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno_apoderado extends Model
{
    protected $table = "alumno_apoderados";
    protected $fillable = [
        'es_principal', // titular o no
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'alumno_id',
        'apoderado_id',
        'anio_academico_id', // Se deja como nullable para permitir relaciones sin especificar el año académico, lo que puede ser útil para casos históricos o relaciones que no estén vinculadas a un año específico.
        'semestre_id', // para saber si el alumno tiene un apoderado específico para un semestre determinado, lo que puede ser útil en casos donde los apoderados cambian entre semestres o para gestionar situaciones especiales.

    ];

    protected $casts = [
        'es_principal' => 'boolean',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function apoderado()
    {
        return $this->belongsTo(Apoderado::class);
    }

    public function anioAcademico()
    {
        return $this->belongsTo(Anio_academico::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    // Scopes útiles
    public function scopeActuales($query)
    {
        return $query->whereNull('fecha_fin');
    }

    public function scopeDelAnio($query, $anioId)
    {
        return $query->where('anio_academico_id', $anioId);
    }


}