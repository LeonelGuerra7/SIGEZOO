<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registros_alimentacion', function (Blueprint $table) {
            $table->id('id_registros');
            $table->dateTime('fecha_registro');
            $table->decimal('cantidad_administrada', 10, 2);
            $table->string('observaciones', 100)->nullable();
            $table->foreignId('id_usuario')->nullable()->constrained('users');
            $table->foreignId('id_dietas')->nullable()
                ->constrained('dietas', 'id_dietas');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros_alimentacion');
    }
};