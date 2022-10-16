<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('p1');
            $table->unsignedBigInteger('p2');
            $table->unsignedBigInteger('torneo_id');
            $table->unsignedBigInteger('jornada_id')->nullable();
            $table->unsignedBigInteger('horario_id')->nullable();
            $table->integer('estado')->default(0);

            $table->timestamps();

            $table->foreign('p1')->references('id')->on('parejas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('p2')->references('id')->on('parejas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('torneo_id')->references('id')->on('torneos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('horario_id')->references('id')->on('horarios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jornada_id')->references('id')->on('jornadas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partidos');
    }
}
