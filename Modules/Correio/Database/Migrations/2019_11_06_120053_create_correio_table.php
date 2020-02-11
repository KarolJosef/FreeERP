<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorreioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('objeto',13);
            $table->string('descricao',55);
            $table->integer('linhas')->nullable();
            $table->integer('isToNotify')->nullable();
            $table->string('ultimaAtualizacao',300);
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
        Schema::dropIfExists('correio');
    }
}
