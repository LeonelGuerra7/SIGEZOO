<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('areas')->insert([
            ['nombre_area' => 'Jaula Felinos', 'tipo_area' => 'jaula', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Jaula Aves', 'tipo_area' => 'jaula', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Jaula Reptiles', 'tipo_area' => 'jaula', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Sanitarios Zona Norte', 'tipo_area' => 'sanitario', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Jardín Central', 'tipo_area' => 'jardín', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Área de Juegos Infantiles', 'tipo_area' => 'área de juegos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_area' => 'Oficinas Administrativas', 'tipo_area' => 'oficina', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}