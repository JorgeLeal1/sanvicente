<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    use HasFactory;

    protected $table = 'ciclos';

    protected $fillable = [
        'nombre',
        'estado',
        'semestre_id'
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];

    // ==================== RELACIONES ====================

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
