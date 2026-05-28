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
    Schema::create('direcciones', function (Blueprint $table) {
            
            $table->engine = 'InnoDB'; // Para asegurar que se utilice InnoDB como motor de almacenamiento y ver las relaciones entre tablas    
            $table->id()->primary()->autoIncrement(); // Laravel usa 'id' por defecto
            $table->string('descripcion',200);
            $table->integer('numero')->nullable();
            $table->boolean('casa')->nullable(); // Agregamos el campo 'casa' para indicar si es una casa o departamento
            $table->string('block',150)->nullable();
            $table->string('departamento',150)->nullable();
            $table->integer('piso')->nullable();
            $table->string('villa_poblacion',150);
            $table->string('comuna',150);
            $table->string('ciudad',150);
            $table->string('region',150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
