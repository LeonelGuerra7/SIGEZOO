<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id('id_alimientos');
            $table->string('nombre_alimento', 50);
            $table->enum('tipo_alimento', [
                'carne', 'pescado', 'forraje', 'concentrado', 'fruta',
                'verdura', 'semillas', 'insectos', 'suplemento',
            ]);
            $table->integer('stock_alimento');
            $table->integer('stock_minimo_alimento');
            $table->string('unidad_medida_alimento', 20);
            $table->foreignId('id_proveedores')->nullable()
                ->constrained('proveedores', 'id_proveedores');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};