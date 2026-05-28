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
        Schema::create('cursos', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas
            $table->id()->primary()->autoIncrement();
            $table->string('nivel');
            $table->char('letra', 1);
            $table->integer('estado')->default(1); // 0=inactivo, 1=activo
            $table->foreignId('ciclo_id')->constrained('ciclos');
            $table->foreignId('profesor_jefe_id')->nullable()->constrained('profesores'); // El Profesor Jefe
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
