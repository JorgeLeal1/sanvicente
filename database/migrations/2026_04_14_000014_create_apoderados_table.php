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
        Schema::create('apoderados', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->string('relacion',100);
            $table->string('Escolaridad',100)->nullable();
            $table->string('Profesion_oficio',100)->nullable();
            $table->string('tipo_trabajo',100)->nullable();
            $table->string('Ocupacion_actual',100)->nullable();
            $table->integer('Num_hijos')->nullable();
            $table->boolean('vive_con_estudiante')->nullable();
            $table->string('desc_motivo', 200)->nullable();
            $table->boolean('estado')->default(1); // 1: Activo, 0: Inactivo
            $table->string('desc_estado', 200)->nullable();           
            $table->foreignId('persona_id')->constrained('personas'); // Relación con tabla personas

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apoderados');
    }
};
