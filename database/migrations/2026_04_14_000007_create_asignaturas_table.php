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
        Schema::create('asignaturas', function (Blueprint $table) {

            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->integer('codigo')->unique();
            $table->string('nombre',100);
            $table->string('descripcion')->nullable();
            $table->integer('estado')->default(1); // 0 = Inactivo, 1 = Activo
            $table->foreignId('colegio_id')->constrained('colegios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaturas');
    }
};
