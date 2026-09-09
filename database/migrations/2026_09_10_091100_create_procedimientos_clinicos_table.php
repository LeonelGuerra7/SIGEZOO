<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedimientos_clinicos', function (Blueprint $table) {
            $table->id('id_procedimientos_clinicos');
            $table->dateTime('fecha_aplicacion');
            $table->date('fecha_proxima')->nullable();
            $table->string('observaciones_procedimiento', 100)->nullable();
            $table->foreignId('id_animal')->nullable()
                ->constrained('animales', 'id_animal');
            $table->foreignId('id_usuario')->nullable()->constrained('users');
            $table->foreignId('id_medicamento')->nullable()
                ->constrained('medicamentos', 'id_medicamento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedimientos_clinicos');
    }
};