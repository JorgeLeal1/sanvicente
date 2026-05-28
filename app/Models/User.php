<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name', 
    'email', 
    'password',
    'role', //'Profesor' o 'Administrador', dependiendo de la función que desempeñe el usuario en el sistema, se deja como string para mayor flexibilidad en caso de que se requieran roles adicionales en el futuro, pero se podrían implementar como un enum o una tabla de roles si se requiere una gestión más robusta de los roles y permisos en el sistema.
    'estado'
    ])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class);
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class);
    }



}
