<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicamentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medicamentos')->insert([
            ['nombre_medicamento' => 'Vacuna antirrábica', 'tipo_medicamento' => 'vacuna', 'stock_medicamento' => 15, 'stock_minimo_medicamento' => 5, 'unidad_medida_medicamento' => 'dosis', 'id_proveedores' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_medicamento' => 'Complejo B', 'tipo_medicamento' => 'vitamina', 'stock_medicamento' => 40, 'stock_minimo_medicamento' => 10, 'unidad_medida_medicamento' => 'ml', 'id_proveedores' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_medicamento' => 'Antiparasitario', 'tipo_medicamento' => 'medicamento', 'stock_medicamento' => 25, 'stock_minimo_medicamento' => 8, 'unidad_medida_medicamento' => 'ml', 'id_proveedores' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}