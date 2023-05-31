<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [
                'id' => 1,
                'name' => 'Project X',
                'description' => '¿Cuál es el nuevo proyecto de la NASA?
                    Artemis es un programa de vuelos espaciales tripulados dirigido por la NASA para explorar la Luna con el objetivo de volver a llevar una misión tripulada a nuestro satélite por primera vez desde el año 1972, retomando el legado del programa Apolo, el cual transportó hombres a la Luna hasta en 6 misiones diferentes.',
                'is_active' => true
            ],
            [
                'id' => 2,
                'name' => 'Project Y',
                'description' => 'Tesla presentó plan para eliminar los combustibles fósiles de la economía. La presentación desde la sede de Tesla en Austin, Texas, inició con una introducción del "Plan Maestro 3" de la empresa para un "futuro energético sostenible".2',
                'is_active' => true
            ],
            [
                'id' => 3,
                'name' => 'Project Z',
                'description' => 'Sega Games y Sega Interactive se fusionaron en 2020 y pasaron a llamarse Sega Corporation. Sega desarrolló varias franquicias de juegos con ventas multimillonarias, como Sonic the Hedgehog, Total War y Yakuza, y es la productora de juegos arcade más prolífica del mundo.',
                'is_active' => true
            ]
        ]);
    }
}
