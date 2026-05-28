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
        Schema::create('anio_academicos', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->integer('anio_valor'); // Ejemplo: 2024, 2025
            $table->integer('estado')->default(1); // 0 = Inactivo, 1 = Activo
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_termino')->nullable();
            $table->foreignId('colegio_id')->constrained('colegios'); // Relación con Colegio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anio_academicos');
    }
};
