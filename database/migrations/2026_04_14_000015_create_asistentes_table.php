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
        Schema::create('asistentes', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->string('cargo',100);           
            $table->integer('num_rol')->nullable()->default(0);
            $table->boolean('estado')->default(1); // 1: Activo, 0: Inactivo
            $table->foreignId('persona_id')->constrained('personas'); // Relación con tabla personas
            $table->foreignId('user_id')->constrained('users'); // Relación con tabla users de Laravel

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistentes');
    }
};
