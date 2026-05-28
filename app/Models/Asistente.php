<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    protected $table = 'asistentes'; // Laravel busca "asistentes" por defecto, así que especificamos
    protected $fillable = [

        'cargo', // Cargo del asistente, por ejemplo: "Secretaria", "Administrativo", etc. Se podría implementar como un enum o una tabla de cargos si se requiere una gestión más robusta de los cargos en el sistema, pero se deja como un campo adicional para mayor flexibilidad en caso de que se requieran cargos adicionales en el futuro.
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

}