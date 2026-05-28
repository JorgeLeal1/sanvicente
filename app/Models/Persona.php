<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas'; // Laravel busca "personas" por defecto, así que especificamos
    protected $fillable = [
        'rut', 
        'nombre1', 
        'nombre2',
        'apellido1',
        'apellido2',
        'edad',
        'fecha_nacimiento', 
        'genero', // 'M' o 'F'
        'telefono',
        'email',
        'nacionalidad',
        'estado', // 0 = Inactivo, 1 = Activo
        'direccion_id'
    ];

    public function fullName(): string
    {
        return "{$this->nombre1} {$this->nombre2} {$this->apellido1} {$this->apellido2}";
    }

    public function direccion() {
        return $this->belongsTo(Direccion::class, 'direccion_id');
    }

}