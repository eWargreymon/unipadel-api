<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTorneosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torneos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha_limite');
            $table->integer('formato');
            $table->string('ciudad');
            $table->string('club');
            $table->integer('max_jugadores');
            $table->float('precio');
            $table->string('descripcion');
            $table->integer('activo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('torneos');
    }
}
