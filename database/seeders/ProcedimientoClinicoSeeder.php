<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProcedimientoClinicoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('procedimientos_clinicos')->insert([
            ['fecha_aplicacion' => now(), 'fecha_proxima' => now()->addMonths(6), 'observaciones_procedimiento' => 'Refuerzo anual', 'id_animal' => 1, 'id_usuario' => 2, 'id_medicamento' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['fecha_aplicacion' => now(), 'fecha_proxima' => null, 'observaciones_procedimiento' => 'Tratamiento por infección leve', 'id_animal' => 4, 'id_usuario' => 2, 'id_medicamento' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}