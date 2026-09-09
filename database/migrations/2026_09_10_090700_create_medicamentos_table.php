<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id('id_medicamento');
            $table->string('nombre_medicamento', 50);
            $table->enum('tipo_medicamento', ['medicamento', 'vacuna', 'vitamina']);
            $table->integer('stock_medicamento');
            $table->integer('stock_minimo_medicamento');
            $table->string('unidad_medida_medicamento', 18);
            $table->foreignId('id_proveedores')->nullable()
                ->constrained('proveedores', 'id_proveedores');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};