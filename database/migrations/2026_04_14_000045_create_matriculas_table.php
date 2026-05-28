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
        Schema::create('matriculas', function (Blueprint $table) {

            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas
            $table->id()->primary()->autoIncrement();
            $table->integer('num_rol')->nullable()->default(0);
            $table->integer('num_matricula')->nullable()->default(0);
            $table->integer('num_pago_cgp')->nullable()->default(0);
            $table->date('fecha_matricula');
            $table->date('fecha_retiro')->nullable();
            $table->boolean('estado_matricula')->default(1); // 1: Activa, 0: Retirada
            $table->string('observaciones', 200)->nullable();

            // ==================  Foreign keys =========================
            // id_entrevistador(user_id)
            $table->foreignId('alumno_id')->constrained('alumnos');
            $table->foreignId('curso_id')->constrained('cursos');
            $table->foreignId('anio_academico_id')->constrained('anio_academicos');
            $table->foreignId('semestre_id')->nullable()->constrained('semestres');

            $table->timestamps();

            $table->unique(['alumno_id', 'curso_id', 'anio_academico_id', 'semestre_id'], 'matricula_unica');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
