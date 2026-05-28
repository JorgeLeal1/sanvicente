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
        Schema::create('promedio_semestres', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->decimal('promedio', 3, 2)->default(0); // Promedio del semestre
            $table->integer('total_evaluaciones')->default(0)->nullable();
            $table->decimal('promedio_final_anual', 3, 2)->default(0)->nullable();
            $table->foreignId('semestre_id')->constrained('semestres');
            $table->foreignId('matricula_id')->constrained('matriculas');
            $table->foreignId('carga_academica_id')->constrained('carga_academicas');

            $table->timestamps();

           // $table->unique(['matricula_id', 'carga_academica_id', 'semestre_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promedio_semestres');
    }
};
