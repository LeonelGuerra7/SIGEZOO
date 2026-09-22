<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('proveedores')->insert([
            ['nombre_proveedor' => 'Alimentos del Campo S.A.', 'numero_proveedor' => 5011, 'email_proveedor' => 'contacto@alimentosdelcampo.test', 'created_at' => now(), 'updated_at' => now()],
            ['nombre_proveedor' => 'Veterinaria Central', 'numero_proveedor' => 5022, 'email_proveedor' => 'ventas@vetcentral.test', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}