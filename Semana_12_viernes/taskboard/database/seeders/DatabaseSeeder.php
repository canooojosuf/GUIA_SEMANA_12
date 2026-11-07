<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $ana = User::create([
            'name' => 'Ana López',
            'email' => 'ana@taskboard.test',
            'password' => 'password123',
        ]);


        $carlos = User::create([
            'name' => 'Carlos Pérez',
            'email' => 'carlos@taskboard.test',
            'password' => 'password123',
        ]);


        $ana->comercios()->create([
            'nombre_comercio' => 'Café Amanecer',
            'rubro' => 'Cafeteria',
            'telefono' => '2200-1111'
        ]);

        $carlos->comercios()->create([
            'nombre_comercio' => 'Ferreteria El Tornillo',
            'rubro' => 'Ferreteria',
            'telefono' => '2200-2222'
        ]);
    }
}
