<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tareas_limpieza', function (Blueprint $table) {
            $table->id('id_limpieza');
            $table->dateTime('fecha_limpieza');
            $table->enum('estado_limpieza', ['Completo', 'Incompleto']);
            $table->string('observaciones_limpieza', 100)->nullable();
            $table->foreignId('id_usuario')->nullable()->constrained('users');
            $table->foreignId('id_areas')->nullable()
                ->constrained('areas', 'id_areas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tareas_limpieza');
    }
};