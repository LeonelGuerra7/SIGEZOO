<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntradaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('entradas')->insert([
            ['fecha_visita' => now(), 'cantidad_entrada' => 2, 'total' => 100.00, 'estado_pago' => 'pagado', 'fecha_compra' => now(), 'id_tipo_entrada' => 1, 'id_promociones' => null, 'id_usuario' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['fecha_visita' => now()->addDays(2), 'cantidad_entrada' => 1, 'total' => 20.00, 'estado_pago' => 'pagado', 'fecha_compra' => now(), 'id_tipo_entrada' => 2, 'id_promociones' => 1, 'id_usuario' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}