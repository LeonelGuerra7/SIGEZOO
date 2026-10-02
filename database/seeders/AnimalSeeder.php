<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('animales')->insert([
            ['nombre_animal' => 'Simba', 'especie_animal' => 'León', 'fecha_nacimiento_animal' => '2020-05-10', 'sexo_animal' => 'Macho', 'estado_animal' => 'activo', 'id_areas' => 1, 'id_dietas' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_animal' => 'Nala', 'especie_animal' => 'León', 'fecha_nacimiento_animal' => '2021-03-22', 'sexo_animal' => 'Hembra', 'estado_animal' => 'activo', 'id_areas' => 1, 'id_dietas' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_animal' => 'Kiwi', 'especie_animal' => 'Guacamaya', 'fecha_nacimiento_animal' => '2019-08-15', 'sexo_animal' => 'Macho', 'estado_animal' => 'activo', 'id_areas' => 2, 'id_dietas' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nombre_animal' => 'Draco', 'especie_animal' => 'Iguana', 'fecha_nacimiento_animal' => '2022-01-05', 'sexo_animal' => 'Macho', 'estado_animal' => 'en_tratamiento', 'id_areas' => 3, 'id_dietas' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}