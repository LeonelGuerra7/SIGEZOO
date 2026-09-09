<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id('id_entradas');
            $table->dateTime('fecha_visita');
            $table->integer('cantidad_entrada');
            $table->decimal('total', 10, 2);
            $table->string('estado_pago', 20);
            $table->dateTime('fecha_compra');
            $table->foreignId('id_tipo_entrada')->nullable()
                ->constrained('tipos_entrada', 'id_tipo_entrada');
            $table->foreignId('id_promociones')->nullable()
                ->constrained('promociones', 'id_promociones');
            $table->foreignId('id_usuario')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};