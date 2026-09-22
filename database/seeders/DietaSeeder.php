<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DietaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('dietas')->insert([
            ['nombre_dieta' => 'Dieta felinos adultos', 'cantidad_dieta' => 4, 'frecuencia' => 'diaria', 'fecha_distribucion' => now(), 'id_alimentos' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_dieta' => 'Dieta aves tropicales', 'cantidad_dieta' => 1, 'frecuencia' => 'diaria', 'fecha_distribucion' => now(), 'id_alimentos' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_dieta' => 'Dieta reptiles', 'cantidad_dieta' => 1, 'frecuencia' => 'cada 3 días', 'fecha_distribucion' => now(), 'id_alimentos' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}