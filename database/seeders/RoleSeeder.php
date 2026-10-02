<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['rol_nombre' => 'administrador', 'rol_descripcion' => 'Acceso total al sistema', 'created_at' => now(), 'updated_at' => now()],
            ['rol_nombre' => 'operativo', 'rol_descripcion' => 'Personal de limpieza, alimentación y clínica', 'created_at' => now(), 'updated_at' => now()],
            ['rol_nombre' => 'visitante', 'rol_descripcion' => 'Usuario público que compra entradas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}