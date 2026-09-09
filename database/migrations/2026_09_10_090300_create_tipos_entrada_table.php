<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipos_entrada', function (Blueprint $table) {
            $table->id('id_tipo_entrada');
            $table->enum('nombre_entrada', [
                'general', 'niño', 'adulto_mayor', 'estudiante', 'discapacidad', 'grupo',
            ]);
            $table->decimal('precio_entrada', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipos_entrada');
    }
};