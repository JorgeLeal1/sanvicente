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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->decimal('nota', 3, 2)->default(0)->nullable();
            $table->date('fecha')->nullable();
            $table->foreignId('matricula_id')->constrained('matriculas');
            $table->foreignId('carga_academica_id')->constrained('carga_academicas');
            $table->foreignId('tipo_evaluacion_id')->constrained('tipo_evaluaciones'); // para saber si es parcial, final, etc.
            $table->foreignId('user_id')->constrained('users'); // registra el usuario
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
