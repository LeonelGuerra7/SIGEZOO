<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $admin = Role::where('rol_nombre', Role::ADMINISTRADOR)->first();
        $operativo = Role::where('rol_nombre', Role::OPERATIVO)->first();
        $visitante = Role::where('rol_nombre', Role::VISITANTE)->first();

        User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@sigezoo.test',
            'password' => bcrypt('password'),
            'id_rol' => $admin->id_rol,
        ]);

        User::factory()->create([
            'name' => 'Operativo',
            'email' => 'operativo@sigezoo.test',
            'password' => bcrypt('password'),
            'id_rol' => $operativo->id_rol,
        ]);

        User::factory()->create([
            'name' => 'Visitante',
            'email' => 'visitante@sigezoo.test',
            'password' => bcrypt('password'),
            'id_rol' => $visitante->id_rol,
        ]);
    }
}
