<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFolhaPagamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folha_pagamento', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->double('salario', 9,2); //1,000 a 999999,999
			$table->double('horas_extras', 3,2)->nullable();
			$table->double('adicional_noturno', 3,2)->nullable();
			$table->double('inss', 3,2);
            $table->integer('faltas');
            $table->date('emissao');
            $table->integer('funcionario_id')->index('fk_folha_pagamento_funcionario1');
            $table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('folha_pagamento');
    }
}
