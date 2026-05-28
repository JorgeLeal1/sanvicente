<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    protected $table = 'profesores'; // Laravel busca "profesors" por defecto, así que especificamos
    protected $fillable = [
        'especialidad',
        'num_rol', // Número de rol para facilitar la gestión de permisos en el sistema, se podría implementar como un enum o una tabla de roles si se requiere una gestión más robusta de los roles y permisos en el sistema, pero se deja como un campo adicional para mayor flexibilidad en caso de que se requieran roles adicionales en el futuro.
        'estado',
        'persona_id',
        'user_id',

    ];

    public function persona(){
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id');
    }

// Cursos donde imparte clases en un año específico
    public function cargasAcademicas()
    {
        return $this->hasMany(Carga_academica::class);
    }

    public function cursosDelAnio(int $anioAcademicoId)
    {
        return $this->cargasAcademicas()
                    ->with(['curso', 'asignatura'])
                    ->where('anio_academico_id', $anioAcademicoId)
                    ->get();
    }

    // Cursos donde es profesor jefe
    public function cursosComoJefe()
    {
        return $this->hasMany(Curso::class, 'profesor_jefe_id');
    }

}