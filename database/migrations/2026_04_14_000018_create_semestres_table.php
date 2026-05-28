<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semestres', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->integer('numero_semestre'); // Ejemplo: 1 para Primer Semestre, 2 para Segundo Semestre
            $table->string('nombre'); // Ejemplo: "Primer Semestre", "Segundo Semestre"
            $table->integer('estado')->default(1); // 0 = Inactivo, 1 = Activo
            $table->date('fecha_inicio');
            $table->date('fecha_termino');
            $table->foreignId('anio_academico_id')->constrained('anio_academicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
