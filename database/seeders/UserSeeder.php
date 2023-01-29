<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert(
            [
                [
                    'name' => 'Organizador 1',
                    'email' => 'organizador@unipadel.com',
                    'tipo' => 1
                ],
                [
                    'name' => 'Organizador 2',
                    'email' => 'admin@organizador.com',
                    'tipo' => 1
                ],
                [
                    'name' => 'Jugador 1',
                    'email' => 'jugador1@unipadel.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 3',
                    'email' => 'j1@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 2',
                    'email' => 'jugador2@unipadel.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 4',
                    'email' => 'j4@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 5',
                    'email' => 'j5@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 6',
                    'email' => 'j6@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 7',
                    'email' => 'j7@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 8',
                    'email' => 'j8@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 9',
                    'email' => 'j9@j.com',
                    'tipo' => 0
                ],
                [
                    'name' => 'Jugador 10',
                    'email' => 'j10@j.com',
                    'tipo' => 0
                ]
            ]
        );

        // DB::table('users')->insert([
        //     'name' => 'Organizador 2',
        //     'email' => 'o1@o.com',
        //     'tipo' => 1
        // ]);
    }
}
