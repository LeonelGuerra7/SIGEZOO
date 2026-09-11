<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['rol_nombre' => Role::ADMINISTRADOR, 'rol_descripcion' => 'Acceso total al sistema'],
            ['rol_nombre' => Role::OPERATIVO, 'rol_descripcion' => 'Personal operativo del zoológico'],
            ['rol_nombre' => Role::VISITANTE, 'rol_descripcion' => 'Usuario del portal público'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['rol_nombre' => $role['rol_nombre']], $role);
        }
    }
}
