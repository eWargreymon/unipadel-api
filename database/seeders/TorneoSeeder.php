<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TorneoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('torneos')->insert([
            [
                "activo" => true,
                "ciudad" => "Las Palmas de Gran Canaria",
                "club" => "Club Sánchez",
                "descripcion" => "Descripción de prueba del torneo",
                "fecha_fin" => "2022-09-30",
                "fecha_inicio" => "2022-09-20",
                "fecha_limite" => "2022-09-15",
                "formato" => 1,
                "max_parejas" => "12",
                "nombre" => "Waiting",
                "organizador_id" => "1",
                "precio" => "12",
            ]
        ]);
        DB::table('torneos')->insert([
            [
                "activo" => false,
                "ciudad" => "Las Palmas de Gran Canaria",
                "club" => "Club Sánchez",
                "descripcion" => "Descripción de prueba del torneo",
                "fecha_fin" => "2022-09-30",
                "fecha_inicio" => "2022-09-20",
                "fecha_limite" => "2022-09-15",
                "formato" => 1,
                "max_parejas" => "12",
                "nombre" => "Playing",
                "organizador_id" => "1",
                "precio" => "12",
                "en_juego" => "1"
            ]
        ]);
    }
}
