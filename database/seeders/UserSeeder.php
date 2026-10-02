<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Zoológico',
            'email' => 'admin@miradasalvaje.test',
            'password' => Hash::make('password'),
            'id_rol' => 1, // administrador
        ]);

        User::create([
            'name' => 'Operativo Encargado',
            'email' => 'operativo@miradasalvaje.test',
            'password' => Hash::make('password'),
            'id_rol' => 2, // operativo
        ]);

        User::create([
            'name' => 'Visitante Demo',
            'email' => 'visitante@miradasalvaje.test',
            'password' => Hash::make('password'),
            'id_rol' => 3, // visitante
        ]);
    }
}