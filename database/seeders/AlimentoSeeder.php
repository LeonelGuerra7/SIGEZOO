<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlimentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('alimentos')->insert([
            ['nombre_alimento' => 'Carne cruda', 'tipo_alimento' => 'carne', 'stock_alimento' => 50, 'stock_minimo_alimento' => 10, 'unidad_medida_alimento' => 'kg', 'id_proveedores' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_alimento' => 'Semillas mixtas', 'tipo_alimento' => 'semillas', 'stock_alimento' => 30, 'stock_minimo_alimento' => 5, 'unidad_medida_alimento' => 'kg', 'id_proveedores' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_alimento' => 'Fruta variada', 'tipo_alimento' => 'fruta', 'stock_alimento' => 20, 'stock_minimo_alimento' => 5, 'unidad_medida_alimento' => 'kg', 'id_proveedores' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}