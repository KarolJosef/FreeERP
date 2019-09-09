<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstoqueHasProduto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('estoque_has_produto', function (Blueprint $table) {
          $table->integer('estoque_id');
          $table->integer('produto_id')->index('fk_estoque_has_produto');
          $table->integer('tipo_unidade_id')->index('fk_tipo_unidade');
          $table->primary(['estoque_id','produto_id']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::drop('estoque_has_produto');
    }
}
