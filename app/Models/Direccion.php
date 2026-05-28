<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = "direcciones";
    protected $fillable = [
        "descripcion",
        "numero",
        "casa",
        "block",
        "departamento",
        "piso",
        "villa_poblacion",
        "comuna",
        "ciudad",
        "region"
    ];

public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class);
    }

}
