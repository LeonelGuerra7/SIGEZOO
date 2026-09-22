<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            ProveedorSeeder::class,
            TipoEntradaSeeder::class,
            PromocionSeeder::class,
            AreaSeeder::class,
            AlimentoSeeder::class,
            MedicamentoSeeder::class,
            DietaSeeder::class,
            UserSeeder::class,
            AnimalSeeder::class,
            TareaLimpiezaSeeder::class,
            ProcedimientoClinicoSeeder::class,
            RegistroAlimentacionSeeder::class,
            EntradaSeeder::class,
        ]);
    }
}