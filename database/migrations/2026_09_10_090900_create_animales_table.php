<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('animales', function (Blueprint $table) {
            $table->id('id_animal');
            $table->string('nombre_animal', 50);
            $table->string('especie_animal', 30);
            $table->date('fecha_nacimiento_animal');
            $table->enum('sexo_animal', ['Macho', 'Hembra']);
            $table->string('estado_animal', 50);
            $table->foreignId('id_areas')->nullable()
                ->constrained('areas', 'id_areas');
            $table->foreignId('id_dietas')->nullable()
                ->constrained('dietas', 'id_dietas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('animales');
    }
};