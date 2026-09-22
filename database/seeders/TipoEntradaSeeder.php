<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoEntradaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_entrada')->insert([
            ['nombre_entrada' => 'general', 'precio_entrada' => 50.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_entrada' => 'niño', 'precio_entrada' => 25.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_entrada' => 'adulto_mayor', 'precio_entrada' => 30.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_entrada' => 'estudiante', 'precio_entrada' => 35.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_entrada' => 'discapacidad', 'precio_entrada' => 25.00, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_entrada' => 'grupo', 'precio_entrada' => 40.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}