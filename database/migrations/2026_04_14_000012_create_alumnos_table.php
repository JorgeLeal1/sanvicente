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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement();
            $table->string('estado')->default(1); // 0 = Inactivo, 1 = Activo
            $table->string('pueblo_originario')->nullable(); // Nuevo campo para indicar el pueblo originario del alumno, string
            $table->boolean('pertenece_etnia')->nullable(); // Nuevo campo para indicar si el alumno pertenece a una etnia específica, booleano (true/false)
            $table->boolean('cursos_repetidos')->nullable();
            $table->string('motivo')->nullable(); 
            $table->foreignId('persona_id')->unique()->constrained('personas');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Relación con tabla users, nullable porque no todos los alumnos tendrán acceso a la plataforma, se deja la opción de crear un usuario para el alumno en caso de que se requiera acceso a la plataforma.    
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
