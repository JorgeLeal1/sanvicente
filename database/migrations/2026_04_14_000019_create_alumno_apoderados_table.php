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
        Schema::create('alumno_apoderados', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->boolean('es_principal')->default(false); // Indica si es el apoderado principal 1: Sí, 0: No
            $table->boolean('estado')->default(1); // 1: Activo, 0: Inactivo
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('apoderado_id')->constrained('apoderados')->onDelete('cascade');
            $table->foreignId('anio_academico_id')->nullable()->constrained('anio_academicos');
            $table->foreignId('semestre_id')->nullable()->constrained('semestres');

            $table->timestamps();

            // Evitar duplicados
            $table->unique(['alumno_id', 'apoderado_id']);
            
            // Un alumno solo puede tener un apoderado principal
            $table->index('es_principal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumno_apoderados');
    }
};
