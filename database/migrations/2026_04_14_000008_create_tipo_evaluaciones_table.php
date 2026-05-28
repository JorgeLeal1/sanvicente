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
    Schema::create('tipo_evaluaciones', function (Blueprint $table) {
        
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement(); // Laravel usa 'id' por defecto
            $table->string('nombre',150);
            $table->string('descripcion',255)->nullable();
            $table->string('codigo',50)->unique();
            $table->integer('estado')->default(1); // 1 para activo, 0 para inactivo
            $table->integer('orden')->default(0);
            $table->foreignId('asignatura_id')->constrained('asignaturas'); // Relación con asignaturas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_evaluaciones');
    }
};
