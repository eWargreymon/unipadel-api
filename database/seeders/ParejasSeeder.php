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
                "nombre" => "A"
            ]
        ]);
        DB::table('parejas')->insert([
            [
                "nombre" => "B"
            ]
        ]);
        DB::table('parejas')->insert([
            [
                "nombre" => "C"
            ]
        ]);
        DB::table('parejas')->insert([
            [
                "nombre" => "D"
            ]
        ]);
    }
}
