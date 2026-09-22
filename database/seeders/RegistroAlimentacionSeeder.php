<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistroAlimentacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('registros_alimentacion')->insert([
            ['fecha_registro' => now(), 'cantidad_administrada' => 4.00, 'observaciones' => null, 'id_usuario' => 2, 'id_dietas' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['fecha_registro' => now(), 'cantidad_administrada' => 1.00, 'observaciones' => null, 'id_usuario' => 2, 'id_dietas' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}