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
        Schema::create('personas', function (Blueprint $table) {
            
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->string('rut')->unique();
            $table->string('nombre1',100);
            $table->string('nombre2',100)->nullable();
            $table->string('apellido1',100);
            $table->string('apellido2',100)->nullable();
            $table->integer('edad');
            $table->date('fecha_nacimiento');
            $table->string('genero', 1); // 'M' o 'F'
            $table->integer('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('nacionalidad', 100)->nullable();
            $table->integer('estado')->default(1); // 0 = Inactivo, 1 = Activo
            $table->foreignId('direccion_id')->constrained('direcciones');// Relación con tabla direcciones
            $table->timestamps();

            // Se podría agregar relacion con tabla de apoderados si se requiere, pero se deja para una futura migración para mantener esta tabla lo más simple posible en esta etapa inicial del desarrollo.   
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
