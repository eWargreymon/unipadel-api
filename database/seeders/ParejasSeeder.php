<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParejasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parejas')->insert([
            [
                "nombre" => "Pareja 1"
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "1",
                "id_jugador" => "3",
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "1",
                "id_jugador" => "4",
            ]
        ]);

        DB::table('parejas')->insert([
            [
                "nombre" => "Pareja 2"
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "2",
                "id_jugador" => "5",
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "2",
                "id_jugador" => "6",
            ]
        ]);

        DB::table('parejas')->insert([
            [
                "nombre" => "Pareja 3"
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "3",
                "id_jugador" => "7",
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "3",
                "id_jugador" => "8",
            ]
        ]);

        DB::table('parejas')->insert([
            [
                "nombre" => "Pareja 4"
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "4",
                "id_jugador" => "9",
            ]
        ]);

        DB::table('integrantes')->insert([
            [
                "id_pareja" => "4",
                "id_jugador" => "10",
            ]
        ]);
    }
}
