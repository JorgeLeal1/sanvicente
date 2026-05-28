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
        Schema::create('carga_academicas', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->foreignId('profesor_id')->constrained('profesores');
            $table->foreignId('asignatura_id')->constrained('asignaturas');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->foreignId('anio_academico_id')->constrained('anio_academicos');
            $table->timestamps();

           //$table->unique(['asignatura_id', 'curso_id', 'anio_academico_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carga_academicas');
    }
};
