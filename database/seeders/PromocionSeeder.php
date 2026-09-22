<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('promociones')->insert([
            [
                'nombre_promociones' => 'Promo Fin de Semana',
                'descripcion' => '20% de descuento sábados y domingos',
                'descuento_porcentaje' => 20,
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addMonths(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}