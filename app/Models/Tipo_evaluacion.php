<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo_evaluacion extends Model
{
    protected $table = "tipo_evaluaciones";
    protected $fillable = [
        "nombre",
        "descripcion",
        "orden",
        "codigo",
        "estado",
        "asignatura_id" //
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

}
