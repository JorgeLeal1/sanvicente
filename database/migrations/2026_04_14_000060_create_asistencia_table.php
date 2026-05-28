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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->date('fecha');
            $table->integer('estado'); // Ejemplo: 0 = Ausente, 1 = Presente, 2 = Justificado
            $table->text('observacion')->nullable();
            $table->foreignId('matricula_id')->constrained('matriculas');
            $table->foreignId('carga_academica_id')->constrained('carga_academicas');
            $table->foreignId('user_id')->constrained('users'); // registra el usuario que registró la asistencia
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
