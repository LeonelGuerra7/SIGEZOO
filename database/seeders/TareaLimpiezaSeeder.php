<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareaLimpiezaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tareas_limpieza')->insert([
            ['fecha_limpieza' => now(), 'estado_limpieza' => 'Completo', 'observaciones_limpieza' => 'Sin novedad', 'id_usuario' => 2, 'id_areas' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['fecha_limpieza' => now(), 'estado_limpieza' => 'Incompleto', 'observaciones_limpieza' => 'Falta desinfectar bebederos', 'id_usuario' => 2, 'id_areas' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}