<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dietas', function (Blueprint $table) {
            $table->id('id_dietas');
            $table->string('nombre_dieta', 50);
            $table->integer('cantidad_dieta');
            $table->string('frecuencia', 50);
            $table->dateTime('fecha_distribucion');
            $table->foreignId('id_alimentos')->nullable()
                ->constrained('alimentos', 'id_alimientos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dietas');
    }
};